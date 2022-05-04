<div class = wrap>
    <h1> Configuration</h1>

    <form method="post" action="options.php">
        <?php
        settings_fields('ailearn_general');
        do_settings_sections('ailearn_config');

        ?>
</div>