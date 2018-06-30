// JavaScript Document
$(document).ready(function () {

    if (document.getElementById('about')) {
        document.getElementById('about').onclick = getContent;
    }
    if (document.getElementById('use')) {
        document.getElementById('use').onclick = getRules;
    }
    if ($("#auth")) {

        $("#auth").popUpPlugIn();

    }
    if (document.getElementById('generate')) {
        document.getElementById('generate').onclick = getResult;
    }
    if (document.getElementById('all_users')) {
        document.getElementById('all_users').onclick = getAllUsers;
    }
    if(document.getElementById('all_debters')) {
        document.getElementById('all_debters').onclick = getAllDebters;
    }


    if ($("#question")) {
        $("#question").on("click", function () {

            if ($("body").attr("data-ask")) {
                return;
            } else {

                let block = $("<div class='col-md-4 ask' id='ask'><i id='close' class='fas fa-times fa-lg'></i>" +
                    "<form method='post' action='index.php?route=index/question'>" +
                    "<div class='form-group'><label for='login'>Логин</label>" +
                    "<input type='text' name='login' class='form-control' " +
                    "id='login' placeholder='Введите Ваш логин'></div>" +
                    "<div class='form-group'>" +
                    "<label for='question'>Ваш вопрос:</label><textarea name='text' class='form-control' " +
                    "id='question' rows='5'></textarea>" +
                    "</div><button type='submit' class='btn btn-primary'>Отправить</button></form></div>");
                block.find(".fas").css({
                    float: "right",
                    cursor: "pointer"
                });
                $("body").append(block);
                let ww = $(window).width();
                let wh = $(window).height();
                let mw = block.width() + 30;
                let mh = block.height() + 50;
                let x = (ww - mw) / 2;
                let y = (wh - mh) / 4;
                block.css({
                    left: x + "px",
                    top: y + "px",
                    display: "block"
                }).animate({
                    opacity: 1
                });
                document.querySelector("body").setAttribute("data-ask", "asked");
                $('#close').on("click", function () {
                    block.css({
                        display: "none",
                        opacity: 0
                    }).detach();
                    $("body").removeAttr("data-ask");
                })
            }

        });
    }
    function getAllDebters(e) {
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?route=admin/all_debters', true);
        xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
        xhr.send();
        xhr.onreadystatechange = function () {
            if (this.readyState !== 4) return;
            if (this.status !== 200) {
                alert('ошибка: ' + (this.status ? this.statusText : 'запрос не удался'));
                return;
            } else {
                extractDebters(xhr.responseText);
            }
        }
    }
    function extractDebters(data) {
        var response = JSON.parse(data);
        if(response['result'] !== false) {
            var html = "<table class='table table-dark'><thead><tr><th scope='col'>Наименование должника</th>" +
                "<th scope='col'>ID</th><th scope='col'>Токен</th></tr></thead><tbody>";
            for(var i = 0; i < response.length;i++) {
                html += "<tr><td>" + response[i]['name'] + "</td><td>" + response[i]['id'] + "</td><td>"
                + response[i]['token'] +"</td></tr>";
            }
            html += "</tbody></table>";
            document.getElementById('content').innerHTML = html;
        } else {
            var html = "<div class='admin_zero'>В базе отсуствуют должники</div>";
            document.getElementById('content').innerHTML=html;
        }
    }

    function getAllUsers(e) {
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?route=admin/all_users', true);
        xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
        xhr.send();
        xhr.onreadystatechange = function () {
            if (this.readyState !== 4) return;
            if (this.status !== 200) {
                alert('ошибка: ' + (this.status ? this.statusText : 'запрос не удался'));
                return;
            } else {
                extractUsers(xhr.responseText);
            }
        }

    }

    function extractUsers(data) {
        var response = JSON.parse(data);
        if (response['result'] !== false) {
            var html = "<table class='table table-dark'><thead><tr><th scope='col'>Имя</th>" +
                "<th scope='col'>Отчество</th><th scope='col'>Фамилия</th><th scope='col'>Почта</th>" +
                "<th scope='col'>Логин</th></tr></thead><tbody>";
            for (var i = 0; i < response.length; i++) {
                html += "<tr><td>" + response[i]['firstname'] + "</td><td>" + response[i]['patronymic'] +
                    "</td><td>" + response[i]['lastname'] + "</td><td>" + response[i]['mail'] +
                    "</td><td>" + response[i]['login'] + "</td></tr>";
            }
            html += "</tbody></table>";
            document.getElementById('content').innerHTML=html;
        } else {
            var html = "<div class='admin_zero'>Нет зарегистрированных пользователей</div>";
            document.getElementById('content').innerHTML=html;
        }
    }

    function getResult(e) {
        e.preventDefault();
        this.classList.add('hidden');
        document.getElementById('result').innerHTML = '<div class="col-md-3 loading">' +
            '<span class="loader">Идет загрузка...</span></div>';
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?route=work/result/show', true);
        xhr.setRequestHeader('X-Requested-With', "XMLHttpRequest");
        xhr.send();
        xhr.onreadystatechange = function () {
            if (this.readyState !== 4) return;
            if (this.status !== 200) {
                alert('ошибка: ' + (this.status ? this.statusText : 'запрос не удался'));
                return;
            } else {
                extract(xhr.responseText);
            }
        }
    }

    function extract(response) {
        let data = JSON.parse(response);
        data = beautify(data);
        let html = "<table class='table table-dark'><thead><tr><th scope='col'>Параметр</th>" +
            "<th scope='col'>Значение</th></tr>"
            + "</thead><tbody><tr><td>Наименование должника</td><td>" + data['name'] + "</td></tr>" +
            "<tr><td>Тип</td><td>" + data['type'] + "</td></tr>"
            + "<tr><td>Стадия взыскания</td><td>" + data['stage'] + "</td></tr><tr>";

        if (!data['mark']) {
            html += "<td>Сумма основного долга</td><td>" + data['main_debt']
                + " руб.</td></tr><tr><td>Сумма процентов</td><td>" + data['persentage'] + " руб.</td></tr>" +
                "<tr><td>Неустойка</td><td>"
                + data['forfeit'] + " руб.</td></tr><tr><td>Сумма сформированного резерва</td><td>" + data['reserves']
                + " руб.</td></tr><tr><td>Количество дней просрочки</td><td>" + data['days_of_delay'] + "</td></tr>";
        } else {
            html += "<td>Cумма, включенная в реестр/баланс</td><td>" + data['total_summ'] + "</td></tr>"
                + "<tr><td>Расчетная сумма удовлетворения</td><td>" + data['real_summ'] + "</td></tr>";
        }

        if (!isNaN(data['result']) && !data['mark']) {
            var result = +Math.round(parseFloat(data['result']) * 100) / 100;
            var total_sum = (+data['main_debt']) + (+data['persentage']) + (+data['forfeit']);
            total_sum = +Math.round(parseFloat(total_sum) * 100) / 100;
            var persentage = 100 - ((result / total_sum) * 100);
            var real_persentage = persentage > 0 ? persentage : 0;
            html += "<tr><td>Общая сумма задолженности</td><td>" + total_sum + " руб.</td></tr>" +
                "<tr><td>Рекомендованный дисконт (%) </td>"
                + "<td>" + Math.round(real_persentage) + " %</td></tr><tr><td>Итоговая сумма</td><td>" + result
                + " руб.</td></tr></tbody></table>";
        } else if (!isNaN(data['result']) && data['mark']) {
            var result = +Math.round(parseFloat(data['result']) * 100) / 100;
            var total_sum = data['total_summ'];
            total_sum = +Math.round(parseFloat(total_sum) * 100) / 100;
            var persentage = 100 - ((result / total_sum) * 100);
            var real_persentage = persentage > 0 ? persentage : 0;
            html += "<tr><td>Общая сумма задолженности</td><td>" + total_sum + " руб.</td></tr>" +
                "<tr><td>Рекомендованный дисконт (%) </td>"
                + "<td>" + Math.round(real_persentage) + " %</td></tr><tr><td>Итоговая сумма</td><td>" + result
                + " руб.</td></tr></tbody></table>";
        } else {
            html += "<tr><td>Итоговый результат</td><td>" + data['result'] + "</td></tr></tbody></table>";
        }
        var nav = document.getElementById('navbarNavAltMarkup');
        var link = document.createElement('a');
        link.className = "nav-item nav-link customize";
        link.setAttribute('href', 'index.php');
        link.innerHTML = "В начало";
        nav.appendChild(link);
        document.getElementById('result').innerHTML = html;
    }

    function beautify(data) {
        if (data['stage'] == 'pretrial') {
            data['stage'] = 'Досудебная';
        } else if (data['stage'] == 'trial') {
            data ['stage'] = 'Судебная';
        } else if (data['stage'] == 'execution') {
            data['stage'] = 'Исполнительное производство';
        } else if (data['stage'] == 'bancrupt') {
            data['stage'] = 'Банкротство';
        } else if (data['stage'] == 'liquidation') {
            data['stage'] = 'Ликивдация';
        }

        if (data['type'] == 'individual') {
            data['type'] = 'Физическое лицо';
        } else if (data['type'] == 'entity') {
            data['type'] = 'Юридическое лицо';
        }
        return data;
    }

    function getContent(e) {
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?route=index/xhr_about', true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
        xhr.onreadystatechange = function () {
            if (this.readyState !== 4) return;
            if (this.status != 200) {
                alert('ошибка: ' + (this.status ? this.statusText : 'запрос не удался'));
                return;
            } else {
                var links = document.querySelectorAll('div.navbar-nav a');
                for (var i = 0; i < links.length; i++) {
                    links[i].classList.remove('active');
                }
                document.getElementById('about').classList.add('active');

                document.getElementById('content').innerHTML = this.responseText;
            }
        }

    }


    function getRules(e) {
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?route=index/xhr_rules', true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();
        xhr.onreadystatechange = function () {
            if (this.readyState != 4) return;
            if (this.status != 200) {
                alert('ошибка: ' + (this.status ? this.statusText : 'запрос не удался'));
                return;
            } else {
                var links = document.querySelectorAll('div.navbar-nav a');
                for (var i = 0; i < links.length; i++) {
                    links[i].classList.remove('active');
                }
                document.getElementById('use').classList.add('active');
                document.getElementById('content').innerHTML = this.responseText;
            }
        }

    }


})
