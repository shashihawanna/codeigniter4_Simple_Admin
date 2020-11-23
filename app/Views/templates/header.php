<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/modal.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-datepicker.css">
    <script src="/assets/js/jquery.min.js"></script>
    <title>
        <?php echo $title ?>
    </title>

</head>

<body>
    <?php
    $uri = service('uri');
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Talentedge</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (session()->get('isLoggedIn')) : ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?= ($uri->getSegment(1) == 'student' ? 'active' : null) ?>">
                        <a class="nav-link" href="/student">Student</a>
                    </li>
                    <li class="nav-item <?= ($uri->getSegment(1) == 'subject' ? 'active' : null) ?>">
                        <a class="nav-link" href="/subject">Subject</a>
                    </li>
                    <li class="nav-item <?= ($uri->getSegment(1) == 'score' ? 'active' : null) ?>">
                        <a class="nav-link" href="/score">Scores</a>
                    </li>
                   
                    <?php if($rolId == '2'){ ?>
                        <li class="nav-item <?= ($uri->getSegment(1) == 'user' ? 'active' : null) ?>">
                        <a class="nav-link" href="/user">Users</a>
                    </li>
                    <?php } ?>
                    <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
                        <a class="nav-link" href="/profile">Profile</a>
                    </li>
                </ul>
                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                </ul>
            <?php else : ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?= ($uri->getSegment(1) == '' ? 'active' : null) ?>">
                        <a class="nav-link" href="/">Login</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </nav>