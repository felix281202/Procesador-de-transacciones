<?php

class Layout {

    private $action;
    private $direction;

    function __construct($action)
    {
        $this->action = $action;
        $this->direction = ($this->action) ? "../../" : "";
    }

    public function printHeader()
{
    $header = <<<EOF
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Estudiantes</title>
    
        <!-- Bootstrap core CSS -->
        <link href="{$this->direction}folders\css\librarys\bootstrap\bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="{$this->direction}folders\css\style.css" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-md-7 py-4">
                            <h4 class="text-white">About</h4>
                            <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
                        </div>
                        <div class="col-sm-4 offset-md-1 py-4">
                            <h4 class="text-white">Contact</h4>
                            <ul class="list-unstyled">
                                <li><a href="#" class="text-white">Follow on Twitter</a></li>
                                <li><a href="#" class="text-white">Like on Facebook</a></li>
                                <li><a href="#" class="text-white">Email me</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container d-flex justify-content-between">
                    <strong><a href="{$this->direction}index.php" class="text-white">Home</a></strong>
                    </a><button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </div>
            </div>
        </header>

EOF;

    echo $header;
}

public function printFooter()
{
    $footer = <<<EOF

    <footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Volver arriba</a>
        </p>
        <p>Registro de estudiantes universitarios</p>
    </div>
</footer>
<script src="{$this->direction}folders\js\librarys\jquery\jquery-3.5.1.min.js"></script>
<script src="{$this->direction}folders\js\librarys\bootstrap\bootstrap.min.js"></script>

</body>

</html>

EOF;

    echo $footer;
}

}

?>

