
<div class="application col-xs-12 col-sm-6 col-md-6 col-lg-6">

    <?php echo Phalcon\Tag::form(array("application/edit", "method" => "get", "name" => "application-form", "role" => "form")) . "\n"; ?>

    <div class="application-top">

        <div class="form-controls">
            <div></div>
            <div>
                <button type="submit" class="btn btn-sm btn-default edit-item"><span><i class="glyphicon glyphicon-pencil"></i></span> </button>
                <button type="button" class="btn btn-sm btn-default application-overview-delete delete-item"><span><i class="glyphicon glyphicon-remove"></i></span> </button>
            </div>
        </div>

    </div>

    <div class="application-bottom row">

        <div class="application-left col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <div class="application-company form-group">
                <?php echo $form->label('company') . "\n"; ?>
                <?php echo $form->render('company') . "\n"; ?>
            </div>

            <div class="application-position form-group">
                <?php echo $form->label('position') . "\n"; ?>
                <?php echo $form->render('position') . "\n"; ?>
            </div>

            <div class="application-notes form-group">
                <?php echo $form->label('notes') . "\n"; ?>
                <?php echo $form->render('notes') . "\n"; ?>
            </div>

            <div class="application-recruitment form-group">
                <?php echo $form->label('recruitment') . "\n"; ?>
                <?php echo $form->render('recruitment') . "\n"; ?>
            </div>

            <?php echo $form->render('app_id') . "\n"; ?>

        </div> <!-- end .application-left -->

        <div class="application-right col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <div class="application-applied form-group">
                <?php echo $form->label('applied') . "\n"; ?>
                <?php echo $form->render('applied') . "\n"; ?>
            </div>

            <div class="application-due-date form-group">
                <?php echo $form->label('due_date') . "\n"; ?>
                <?php echo $form->render('due_date') . "\n"; ?>
            </div>

            <div class="application-follow-up form-group">
                <?php echo $form->label('follow_up') . "\n"; ?>
                <?php echo $form->render('follow_up') . "\n"; ?>
            </div>

            <div class="application-attachments form-group">
                <label>Contacts:</label>
                <ul id="contacts-list">
                    <?php

                    $attachments = ContactAttachments::find(array(
                        'conditions' => 'app_id = ?1',
                        'bind' => array(1 => $application->id)
                    ));

                    $html = '';

                    foreach($attachments as $attachment) {

                        $contact = Contacts::findFirst('id = "' . $attachment->contact_id . '"');

                        $html .= '<li class="bg-success">' . "\n";
                        $html .= '<div>';
                        $html .= '<input type="hidden" value="' . $contact->id . '"/>';
                        $html .= '<span class="contact-name">';
                        $html .= '<a class="attachment-details">' . $contact->name . '</a>';

                        if(strlen($contact->position) > 0) {
                            $html .= '<br>';
                            $html .= '<span class="hidden-xs">';
                            $html .= '(' . $contact->position . ')';
                            $html .= '</span>';
                        }

                        $html .= '</span>';
                        $html .= '</div>';
                        $html .= '</li>';

                    }

                    echo $html;

                    ?>
                </ul>
            </div>

        </div> <!-- end .application-right -->

    </div> <!-- end .application-bottom -->

    <?php echo Phalcon\Tag::endForm() . "\n"; ?>

</div>