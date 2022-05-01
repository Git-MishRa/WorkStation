
<nav class="navbar fixed-top navbar-expand-lg p-0 pr-3 pl-3 navbar-dark bg-dark">
    <a class="navbar-brand" href="#"> Work Station</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i
                            class="fa fa-home"></i></span> Home</a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=files" class="nav-item nav-files"><span class='icon-field'><i
                            class="fa fa-file"></i></span> My Repo</a>
            </li>
            <li class="nav-item">
                <?php if ($_SESSION['login_type'] == 1) : ?>
                <a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i
                            class="fa fa-users"></i></span> Users</a>
                <?php endif; ?>
            </li>
            <li class="nav-item">
                <a href="index.php?page=chat" class="nav-item nav-chat"><span class='icon-field'><i
                            class="fa fa-comment-alt"></i></span> Chat Room</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-item dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><span><i class="fa fa-laptop"></i></span>
                    View
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <input class="form-control mr-md-2" id="roomCreate" type="search" placeholder="Create Room" aria-label="Search">
                    <input class="form-control mr-md-2" id="roomJoin" type="search" placeholder="Join Room" aria-label="Search">
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-item dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['login_name'] ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/workstation/includes/actionDispatcher.php?action=logout">Logout</a>
                </div>
            </li>
        </ul>
        <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> -->
        <div class="my-2 mini-btn btn my-lg-0 text-primary"><i class="fas fa-window-minimize"></i></div>
        <div class="my-2 maxi-btn btn my-lg-0 text-primary"><i class="fas fa-window-maximize"></i></div>
    </div>
</nav>
<script>
    $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
    $('.maxi-btn').click(() => {
        document.documentElement.requestFullscreen();
    })
    $('.mini-btn').click(() => {
        document.exitFullscreen();
    })
</script>