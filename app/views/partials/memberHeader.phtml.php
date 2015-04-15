<header>
    <nav class="navbar navbar-default navbar-static-top center" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Job Application Tracker</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php

                    $html = '';

                    if($this->router->getControllerName() == 'application') {
                        $html .= '<li class="active"><a href="/application/overview">Applications</a></li>' . "\n";
                        $html .= '<li><a href="/contacts/overview">Contacts</a></li>' . "\n";
                    } else {
                        $html .= '<li><a href="/application/overview">Applications</a></li>' . "\n";
                        $html .= '<li class="active"><a href="/contacts/overview">Contacts</a></li>' . "\n";
                    }

                    echo $html;

                    ?>

                    <li id="logout"><a>Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header>