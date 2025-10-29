<?php
include 'bd.php';

$dataSelecionada = $_POST['data'] ?? date('Y-m-d'); // pega a data atual ou a escolhida

// Gera todos os horários possíveis de 08:00 às 18:00
$horarios = [];
for ($hora = strtotime('08:00'); $hora <= strtotime('18:00'); $hora += 30 * 60) { // 30 minutos
    $horarios[] = date('H:i', $hora);
}

// Busca os horários já agendados nessa data
$stmt = $conn->prepare("
    SELECT hora_agenda 
    FROM agendamento_cli 
    WHERE data_agenda = ? AND status = 'pendente'
");
$stmt->bind_param("s", $dataSelecionada);
$stmt->execute();
$result = $stmt->get_result();

$ocupados = [];
while ($row = $result->fetch_assoc()) {
    $ocupados[] = substr($row['hora_agenda'], 0, 5); // garante formato HH:MM
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>

<body style="background-color: #f1f1f1ff;">
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="./logo.png" alt=""></a>

            <!-- Botão só aparece em telas menores -->
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu normal em telas grandes -->
            <div class="d-none d-lg-flex align-items-center flex-grow-1 lista-inicio">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row">
                    <li class="nav-item"><a class="nav-link px-3" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#">Contato</a></li>
                    <li class="nav-item ">
                        <a class="nav-link  px-3" href="#">Localização</a>
                    </li>
                    <li class="nav-item botao-marcar ">
                        <a class="px-3" href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Marque Sua Consulta</a>
                    </li>
                </ul>
            </div>


        </div>

        <!-- Offcanvas só aparece em telas menores -->
        <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="offcanvasNavbar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                    <li class="nav-item ">
                        <a class="nav-link " href="#"></a>

                    </li>
                </ul>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Fazer Agendamento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="enviar_email.php">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Seu Nome</label>
                                <input type="text" class="form-control" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Seu CPF</label>
                                <input type="text" class="form-control" name="cpf" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Seu Celular</label>
                                <input type="text" class="form-control" name="celular" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Seu Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Data da Consulta</label>
                                <input type="date" class="form-control" name="data" id="dataConsulta" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Hora da Consulta</label>
                                <select class="form-select" name="hora" id="horaConsulta" required>
                                    <option value="">Selecione uma data primeiro</option>
                                </select>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Agendar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <section>
        <!-- <div id="carouselExampleCaptions" class="carousel slide">
            <p class="titulo-carousel">Quem somos ?</p>
            <hr class="linha-carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./carousel1.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Sou o Dr. Fulano</h5>
                        <p>Formado em Odontologia no ano de 2000, com experiencia a mais de 10 anos.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./carousel2.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Consultorio Odontologico</h5>
                        <p>Nosso consultorio foi criado em 2009, até hoje satisfazendo nossos clientes.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./carousel3.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Clientes</h5>
                        <p>Hoje contamos com mais de 5 mil clientes em toda Fortaleza.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div> -->


        <section class="clinic-carousel" id="carousel-grande">
            <div class="container">

                <h2 class="clinic-carousel-title">Quem somos ?</h2>
                <div class="owl-carousel clinic-carousel-slider owl-theme">

                    <div class="clinic-card active" style="background-image: url(sualogo1.png);">
                        <div class="clinic-card-desc">
                            <h3>Seu Nome</h3>
                            <p>Sua historia resumido</p>
                        </div>
                    </div>

                    <div class="clinic-card" style="background-image: url(sualogo1.png);">
                        <div class="clinic-card-desc">
                            <h3>Sua Clinica</h3>
                            <p>Local resumido da clinica</p>
                        </div>
                    </div>

                    <div class="clinic-card" style="background-image: url(sualogo1.png);">
                        <div class="clinic-card-desc">
                            <h3>Seus Clientes</h3>
                            <p>Post de elogios de seu clientes</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <div id="carouselExampleCaptions" class="carousel slide carousel-pequeno">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./sualogo1.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Seu Nome</h5>
                        <p>Sua historia resumido</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./sualogo1.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Sua Clinica</h5>
                        <p>Local resumido da clinica</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./sualogo1.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption">
                        <h5>Seus Clientes</h5>
                        <p>Post de elogios de seu clientes</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>




        <div class="container">
            <div class="row mt-5">
                <h2 class="clinic-carousel-title">Nossos Serviços </h2>
                <div class="col-lg-4 align-items-stretch d-flex">
                    <div class="card shadow">
                        <div class="card-img-top-overlay">
                            <div class="overlay"></div><span class="bg-success card-badge text-white top-right">Em alta <i class="bi bi-fire"></i></span>
                            <div class="position-relative"><img alt="" class="card-img-top img-same-height" src="./card-img1.png">
                                <div class="shape text-white bottom"><svg width="528px" height="40px" viewBox="0 0 528 40" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                                        <g id="shape" transform="matrix(-1.138336E-07 -1 1 -1.138336E-07 0 39.92764)">
                                            <path d="M0 0L40.5467 0C40.5467 0 -31.8215 230.87 38.7134 528.217C39.8794 533.133 31.7549 527.502 31.0925 528.75C28.7914 533.084 26.1543 528.191 24.4327 529.178C59.2372 539.206 14.0091 521.981 12.9329 530.001L1.02722 528.284L0 0Z" transform="translate(7.629395E-06 6.103516E-05)" fill="currentColor" stroke="none"></path>
                                        </g>
                                    </svg></div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="mt-2">
                                <h4><a class="card-title-link" href="">Limpeza e Restauração</a></h4>
                                <p class="text-muted mb-2">Tratamentos de Limpeza e Restauração para manter seu sorriso saudável, bonito e protegido com segurança e conforto</p>
                                <p>A partir de <br> <span>R$ 100,00</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 align-items-stretch d-flex">
                    <div class="card shadow">
                        <div class="card-img-top-overlay">
                            <div class="overlay"></div><span class="bg-success card-badge text-white top-right">Em alta <i class="bi bi-fire"></i></span>
                            <div class="position-relative"><img alt="" class="card-img-top img-same-height" src="./card-img2.png">
                                <div class="shape text-white bottom"><svg width="528px" height="40px" viewBox="0 0 528 40" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                                        <g id="shape" transform="matrix(-1.138336E-07 -1 1 -1.138336E-07 0 39.92764)">
                                            <path d="M0 0L40.5467 0C40.5467 0 -31.8215 230.87 38.7134 528.217C39.8794 533.133 31.7549 527.502 31.0925 528.75C28.7914 533.084 26.1543 528.191 24.4327 529.178C59.2372 539.206 14.0091 521.981 12.9329 530.001L1.02722 528.284L0 0Z" transform="translate(7.629395E-06 6.103516E-05)" fill="currentColor" stroke="none"></path>
                                        </g>
                                    </svg></div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="mt-2">
                                <h4><a class="card-title-link" href="">Próteses</a></h4>
                                <p class="text-muted mb-2">Próteses modernas e confortáveis que devolvem a estética, a função mastigatória e a confiança no seu sorriso</p>
                                <p>A partir de <br> <span>R$ 100,00</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 align-items-stretch d-flex">
                    <div class="card shadow">
                        <div class="card-img-top-overlay">
                            <div class="overlay"></div><span class="bg-success card-badge text-white top-right">Em alta <i class="bi bi-fire"></i></span>
                            <div class="position-relative"><img alt="" class="card-img-top img-same-height" src="./card-img3.png">
                                <div class="shape text-white bottom"><svg width="528px" height="40px" viewBox="0 0 528 40" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                                        <g id="shape" transform="matrix(-1.138336E-07 -1 1 -1.138336E-07 0 39.92764)">
                                            <path d="M0 0L40.5467 0C40.5467 0 -31.8215 230.87 38.7134 528.217C39.8794 533.133 31.7549 527.502 31.0925 528.75C28.7914 533.084 26.1543 528.191 24.4327 529.178C59.2372 539.206 14.0091 521.981 12.9329 530.001L1.02722 528.284L0 0Z" transform="translate(7.629395E-06 6.103516E-05)" fill="currentColor" stroke="none"></path>
                                        </g>
                                    </svg></div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="mt-2">
                                <h4><a class="card-title-link" href="">Tratamento de Canal</a></h4>
                                <p class="text-muted mb-2">Tratamento de canal seguro e indolor para salvar o dente e manter seu sorriso saudável.</p>
                                <p>A partir de <br> <span>R$ 100,00</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 align-items-stretch d-flex">
                    <div class="card shadow">
                        <div class="card-img-top-overlay">
                            <div class="overlay"></div><span class="bg-success card-badge text-white top-right">Em alta <i class="bi bi-fire"></i></span>
                            <div class="position-relative"><img alt="" class="card-img-top img-same-height" src="./card-img3.png">
                                <div class="shape text-white bottom"><svg width="528px" height="40px" viewBox="0 0 528 40" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                                        <g id="shape" transform="matrix(-1.138336E-07 -1 1 -1.138336E-07 0 39.92764)">
                                            <path d="M0 0L40.5467 0C40.5467 0 -31.8215 230.87 38.7134 528.217C39.8794 533.133 31.7549 527.502 31.0925 528.75C28.7914 533.084 26.1543 528.191 24.4327 529.178C59.2372 539.206 14.0091 521.981 12.9329 530.001L1.02722 528.284L0 0Z" transform="translate(7.629395E-06 6.103516E-05)" fill="currentColor" stroke="none"></path>
                                        </g>
                                    </svg></div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="mt-2">
                                <h4><a class="card-title-link" href="">Tratamento de Canal</a></h4>
                                <p class="text-muted mb-2">Tratamento de canal seguro e indolor para salvar o dente e manter seu sorriso saudável.</p>
                                <p>A partir de <br> <span>R$ 100,00</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 align-items-stretch d-flex">
                    <div class="card shadow">
                        <div class="card-img-top-overlay">
                            <div class="overlay"></div><span class="bg-success card-badge text-white top-right">Em alta <i class="bi bi-fire"></i></span>
                            <div class="position-relative"><img alt="" class="card-img-top img-same-height" src="./card-img3.png">
                                <div class="shape text-white bottom"><svg width="528px" height="40px" viewBox="0 0 528 40" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                                        <g id="shape" transform="matrix(-1.138336E-07 -1 1 -1.138336E-07 0 39.92764)">
                                            <path d="M0 0L40.5467 0C40.5467 0 -31.8215 230.87 38.7134 528.217C39.8794 533.133 31.7549 527.502 31.0925 528.75C28.7914 533.084 26.1543 528.191 24.4327 529.178C59.2372 539.206 14.0091 521.981 12.9329 530.001L1.02722 528.284L0 0Z" transform="translate(7.629395E-06 6.103516E-05)" fill="currentColor" stroke="none"></path>
                                        </g>
                                    </svg></div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="mt-2">
                                <h4><a class="card-title-link" href="">Tratamento de Canal</a></h4>
                                <p class="text-muted mb-2">Tratamento de canal seguro e indolor para salvar o dente e manter seu sorriso saudável.</p>
                                <p>A partir de <br> <span>R$ 100,00</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 align-items-stretch d-flex">
                    <div class="card shadow">
                        <div class="card-img-top-overlay">
                            <div class="overlay"></div><span class="bg-success card-badge text-white top-right">Em alta <i class="bi bi-fire"></i></span>
                            <div class="position-relative"><img alt="" class="card-img-top img-same-height" src="./card-img3.png">
                                <div class="shape text-white bottom"><svg width="528px" height="40px" viewBox="0 0 528 40" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                                        <g id="shape" transform="matrix(-1.138336E-07 -1 1 -1.138336E-07 0 39.92764)">
                                            <path d="M0 0L40.5467 0C40.5467 0 -31.8215 230.87 38.7134 528.217C39.8794 533.133 31.7549 527.502 31.0925 528.75C28.7914 533.084 26.1543 528.191 24.4327 529.178C59.2372 539.206 14.0091 521.981 12.9329 530.001L1.02722 528.284L0 0Z" transform="translate(7.629395E-06 6.103516E-05)" fill="currentColor" stroke="none"></path>
                                        </g>
                                    </svg></div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="mt-2">
                                <h4><a class="card-title-link" href="">Tratamento de Canal</a></h4>
                                <p class="text-muted mb-2">Tratamento de canal seguro e indolor para salvar o dente e manter seu sorriso saudável.</p>
                                <p>A partir de <br> <span>R$ 100,00</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="container mt-5">
            <h2 class="clinic-carousel-title mb-4 text-center">Nossa Localização</h2>

            <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 800px;">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    📍 Rua Tal, 123 - Bairro Aldeota
                </div>
                <div class="card-body p-0">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.012957866125!2d-38.52500802429237!3d-3.807278043579991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7c74e540b3d8f57%3A0xb7514ac6ecd252e3!2sArena%20Castel%C3%A3o!5e0!3m2!1spt-BR!2sbr!4v1761229181450!5m2!1spt-BR!2sbr"
                        width="100%"
                        height="450"
                        style="border:0; border-radius: 0 0 1rem 1rem;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="card-footer text-center bg-light rounded-bottom-4">
                    Fortaleza - CE
                </div>
            </div>
        </div>



    </section>



    <!-- Footer Block Start -->
    <footer id="site-footer">
        <div class="bg-success bg-opacity-25 py-5">
            <div class="container py-3 text-center"> <!-- CENTRALIZA O CONTEÚDO -->
                <div class="row justify-content-center"> <!-- ALINHA AS COLUNAS NO CENTRO -->
                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <h5 class="pb-3"><i class="fa-solid fa-link pe-1"></i>Links Importantes</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="link-body-emphasis link-offset-2 link-underline-opacity-25 link-underline-opacity-75-hover">Sobre Nós</a></li>
                            <li><a href="#" class="link-body-emphasis link-offset-2 link-underline-opacity-25 link-underline-opacity-75-hover">Política de Privacidade</a></li>
                            <li><a href="#" class="link-body-emphasis link-offset-2 link-underline-opacity-25 link-underline-opacity-75-hover">Termos de Serviço</a></li>
                        </ul>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <h5 class="pb-3"><i class="fa-solid fa-location-dot pe-1"></i>Nossa Localização</h5>
                        <span class="text-secondary-emphasis">
                            Rua Tal, 123 - Bairro Aldeota, Fortaleza<br>
                        </span>
                    </div>

                    <div class="col-xl-3 col-md-6 col-sm-12">
                        <h5 class="pb-3"><i class="fa-solid fa-paper-plane pe-1"></i>Marque Sua Consulta</h5>
                        <a href="#" type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Agendar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-dark py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a class="btn btn-outline-secondary" href="#">
                                    <i class="fa-brands fa-facebook-f text-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-outline-secondary" href="#">
                                    <i class="fa-brands fa-instagram text-instagram"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a class="btn btn-outline-secondary" href="#">
                                    <i class="fa-brands fa-whatsapp text-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <span class="text-secondary pt-1 float-md-end float-sm-start">Direitos reservados &copy; 2025</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Block Start -->

    <!-- jQuery (necessário para OwlCarousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <!-- OwlCarousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- OwlCarousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <script>
        $(document).ready(function() {
            $('#dataConsulta').on('change', function() {
                let dataSelecionada = $(this).val();

                if (dataSelecionada) {
                    $.ajax({
                        url: 'buscar_horario.php',
                        method: 'POST',
                        data: {
                            data: dataSelecionada
                        },
                        success: function(response) {
                            $('#horaConsulta').html(response);
                        },
                        error: function() {
                            $('#horaConsulta').html('<option value="">Erro ao carregar horários</option>');
                        }
                    });
                } else {
                    $('#horaConsulta').html('<option value="">Selecione uma data primeiro</option>');
                }
            });
        });
        $(".clinic-carousel-slider").owlCarousel({
            autoWidth: true,

        });

        $(document).ready(function() {
            $(".clinic-carousel-slider .clinic-card").click(function() {
                $(".clinic-carousel-slider .clinic-card").not($(this)).removeClass("active");
                $(this).toggleClass("active");
            });
        });
    </script>
</body>

</html>