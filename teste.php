<div class="container-fluid">
    <div class="row">
        <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
            <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
                aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarMenuLabel">
                        Clinica
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a id="menu-painel" class="nav-link d-flex align-items-center gap-2 active" aria-current="page"
                                href="#">
                                <svg class="bi" aria-hidden="true">
                                    <use xlink:href="#house-fill"></use>
                                </svg>
                                Painel Geral
                            </a>
                        </li>
                    </ul>
                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                        <span>Administração do Painel</span>
                        <a class="link-secondary" href="#" aria-label="Add a new report">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#plus-circle"></use>
                            </svg>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item">
                            <a id="menu-perfil" class="nav-link d-flex align-items-center gap-2" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                </svg>
                                Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="menu-online" class="nav-link d-flex align-items-center gap-2" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-people" viewBox="0 0 16 16">
                                    <path
                                        d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275Z" />
                                </svg>
                                Quem está online
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="menu-add" class="nav-link d-flex align-items-center gap-2" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-fill-add" viewBox="0 0 16 16">
                                    <path
                                        d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path
                                        d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                                </svg>
                                Adicionar Pessoa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="menu-permissoes" class="nav-link d-flex align-items-center gap-2" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-fill-check" viewBox="0 0 16 16">
                                    <path
                                        d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path
                                        d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                                </svg>
                                Permissões Do Painel
                            </a>
                        </li>
                    </ul>

                    <hr class="my-3" />
                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="#">
                                <svg class="bi" aria-hidden="true">
                                    <use xlink:href="#door-closed"></use>
                                </svg>
                                Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ÁREA PRINCIPAL -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <!-- PAINEL GERAL -->
            <div id="conteudo-painel" class="conteudo-ativo">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Olá <?= htmlspecialchars($usuario_nome) ?>, esse é o Painel Geral da Clinica</h1>
                </div>

                <!-- Aqui fica todo o conteúdo do painel (cards + tabela) -->
                <!-- SEU CONTEÚDO ORIGINAL -->
            </div>

            <!-- PERFIL -->
            <div id="conteudo-perfil" class="conteudo-oculto">
                <h1>Perfil do Usuário</h1>
                <p>Nome: <?= htmlspecialchars($usuario_nome) ?></p>
                <p>Email: <?= htmlspecialchars($usuario_email ?? 'exemplo@dominio.com') ?></p>
            </div>

            <!-- QUEM ESTÁ ONLINE -->
            <div id="conteudo-online" class="conteudo-oculto">
                <h1>Quem está online</h1>
                <p>Lista de usuários conectados...</p>
            </div>

            <!-- ADICIONAR PESSOA -->
            <div id="conteudo-add" class="conteudo-oculto">
                <h1>Adicionar Pessoa</h1>
                <form>
                    <input type="text" class="form-control mb-2" placeholder="Nome">
                    <input type="text" class="form-control mb-2" placeholder="Email">
                    <button class="btn btn-primary">Salvar</button>
                </form>
            </div>

            <!-- PERMISSÕES -->
            <div id="conteudo-permissoes" class="conteudo-oculto">
                <h1>Permissões do Painel</h1>
                <p>Configurações de acesso e níveis de permissão...</p>
            </div>

        </main>
    </div>
</div>

<!-- CSS -->
<style>
.conteudo-oculto {
    display: none;
}
.conteudo-ativo {
    display: block;
}
</style>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const botoes = document.querySelectorAll(".nav-link");
    const conteudos = document.querySelectorAll("main > div");

    botoes.forEach(botao => {
        botao.addEventListener("click", function(e) {
            e.preventDefault();

            // Remove 'active' de todos e aplica no atual
            botoes.forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            // Esconde tudo e mostra o conteúdo correspondente
            conteudos.forEach(c => c.classList.remove("conteudo-ativo"));
            conteudos.forEach(c => c.classList.add("conteudo-oculto"));

            const id = this.id.replace("menu-", "conteudo-");
            document.getElementById(id).classList.remove("conteudo-oculto");
            document.getElementById(id).classList.add("conteudo-ativo");
        });
    });
});
</script>
