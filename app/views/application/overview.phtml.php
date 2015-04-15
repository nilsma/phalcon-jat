<div id="main-container">

    <?php $this->partial('partials/memberHeader'); ?>

    <div id="inner-container">

        <?php echo $this->flash->output() . '<br/>'; ?>

        <?php echo $this->partial('partials/controllers-template') . "\n"; ?>

        <div id="applications" class="container">

            <?php

            if(count($applications) > 0) {

                foreach($applications as $application) {

                    $form = new OverviewApplicationForm($application);

                    echo $this->partial('partials/overview-application-template') . "\n";

                }

            } else {

                echo $this->partial('partials/missing-entries') . "\n";

            }

            ?>

            <?php echo $this->partial('partials/contact-modal-presentation') . "\n"; ?>

        </div> <!-- end #applications -->

    </div> <!-- end #inner-container -->

</div> <!-- end #main-container -->