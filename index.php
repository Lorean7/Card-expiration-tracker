<?php

    #подключаем контроллер
    require_once './API/ApiController.php';
    use API\ApiController\ApiController; // Используем класс ApiController из пространства имен

    $apiController = new ApiController();
    $apiController->getToken();
    $cards = $apiController->getCards(512);

    $valid = ($cards[0]->action_date <= date('m/Y'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./style/site.css"/>
    
    <title>Document</title>
</head>
    <body>
        

        <div class="container">
            <h2 >Форма заявки</h2>
            <form action="" method="post" id="form_request">

                <select name="mySelect" id="mySelect">
                <?php
                        foreach ($cards as $card) {
                    ?>
                        <option value="<?= $card->number ?>" data-creation="<?= $card->action_date ?>"><?= $card->number ?></option>
                    <?php } ?>

                </select>
                
                <span id="card-expiration">Карта годна до: <?= $cards[0]->action_date ?></span>
                <?php if(date("m/Y") > $cards[0]->action_date) { ?>
                    <div id="expiration-warning" >
                        Карта "<?= $cards[0]->number ?>",
                        является более не действительной на <?= date("m/Y") ?>,
                        так как срок ее действия прошел <?= $cards[0]->action_date ?>
                    </div>
                <?php } else { ?>
                    <div id="expiration-warning" >
                        Карта "<?= $cards[0]->number ?>",действительна
                        </div><?php } ?>
                        <button id ="btn-submit" <?= $valid ? 'disabled' : '' ?> >Отправить заявку</button>
            </form>
            <button id='btn-unlock-submit' <?= $valid ? '' : 'hidden' ?>>Продолжить, карта действительна</button>

        </div>
            <div id="success-message" class="success-message">
                <h2>Заявка успешно отправлена!</h2>
                <button id="confirm-btn" style="margin-top: 20px;">Подтвердить</button>
            </div>
            
            <div id="dengerous-message" class="dengerous-message">
                <h2>Не удалось пройти авторизацию!</h2>
            </div>
    <script src="./scripts/scripts.js"></script>
    </body>
</html>