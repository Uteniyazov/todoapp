<nav class="navbar navbar-expand-lg bg-dark bodred-bottom border-bottom-dark mb-3" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../admin/index.php">TODO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $page == 'index' ? 'active' : '' ?>" aria-current=" page" href="../admin/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page == 'users' ? 'active' : '' ?>" href="../admin/users.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page == 'tasks' ? 'active' : '' ?>" href="../admin/tasks.php">Tasks</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>