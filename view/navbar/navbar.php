<nav class="navbar navbar-expand-md navbar-light bg-light  border border-right-0 border-left-0 border-top-0">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex flew-row justify-content-around w-100">
            <?= $di->get('navbar')->createNav() ?>
        </ul>
    </div>
</nav>
