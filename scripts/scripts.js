
     //выбор селекта - вешаем слушатель для обработки выбранной опции
     $('#mySelect').on('change', function() {
        //получение данных из опции
        let number_card = $(this).val();
        let selectedOptionCreationDate = $(this).find('option:selected').attr('data-creation');
        console.log(number_card)
         console.log('Выбранная опция была создана : ' + selectedOptionCreationDate);
       //открытие скрытых элементов на странице
        $("span").show();
                //устанавливаем дату текущей опции в соответствующий  элемент на странице
                $('#card-expiration').text('Карта годна до: ' + selectedOptionCreationDate);

                                //проверка даты
        // сравниваем выбранной даты с текущей датой, предварительно разбив строку по селектору и собрак объект Date
        let expirationParts =  selectedOptionCreationDate.split('/');
        let expirationDate = new Date(expirationParts[1], expirationParts[0]);
             
        let currentDate = new Date();
        //получение кнопок для изменениях их атрибутов
        btn_submit = $('#btn-submit');
        btn_unlock_submit = $('#btn-unlock-submit');

        //условие проверки даты
        if (currentDate.getUTCFullYear() <= expirationDate.getUTCFullYear() && currentDate.getUTCMonth() <= expirationDate.getUTCMonth()){
            // карта действительна - вывод сообщения, разблокировка кнопки формы и скрытие кнопки для принудительного оформелние заявки
            $("#expiration-warning").html("Карта действительна");
            btn_submit.prop("disabled", false);
            btn_unlock_submit.prop("hidden", true);
        } else {
            //карта недействительна
            //вешаем слушатель на кнопку отвечающую за принудительную отправку заявки
            btn_unlock_submit.on("click", function(){
                //по нажатию скрыть кнопку принудательной отправки заявки
                // разблокировка кноки формы 
                btn_unlock_submit.prop("hidden", true);
                btn_submit.prop("disabled", false);
                
            })

            //отобразить все элементы span на страницк
            $("span").show();

            //получение блока на странице в котором будет отображаться информация по карте - изменение текста
            $("#expiration-warning").text("Карта " +
                                number_card +
                                " является более не действительной на " +
                                (currentDate.getMonth()+1)+'/' + currentDate.getFullYear() +
                                " так как срок ее действия прошел " +
                                (expirationDate.getUTCMonth()+1) +'/'+ expirationDate.getFullYear()).addClass("disabled");

            //блокировка кнопки формы и отображение кнопки для принудительной отправки заявки
            btn_submit.prop("disabled", true);
            btn_unlock_submit.prop("hidden", false);
        }  
            
        //устанавливаем дату выбранной карты в соответствующий блок на странице
        $('card-expiration').html('Карта годна до:' + selectedOptionCreationDate);
        });
    
    //обработчик кнопки отвечающий за принудительную отправку заявки
     btn_unlock_submit = $('#btn-unlock-submit').click(function () {
        btn_submit = $('#btn-submit').prop('disabled',false);
        information = $('#card-info').prop('hidden',true)
        btn_unlock_submit.prop('hidden',true)
     })

     //получение формы
     form = document.getElementById('form_request');

     //обработки события  submit формы
    form.addEventListener('submit', function(event) {
    
    event.preventDefault(); // отмена действия по умолчанию 
    //отображение кастом модального окна
    alert = document.getElementById('success-message');
    alert.style.display = 'flex';
    // получение кнопки модального окна
    confirm_btn = document.getElementById('confirm-btn');
    //обработчик кнопки модального окна
    confirm_btn.addEventListener('click', function(event) {
        confirm_btn.parentNode.style.display = 'none';
    });


});
