//<script type="text/javascript">
$(document).ready(function () {
//        var currentdate = new Date();
//        var d=currentdate.getDate()+'-'+currentdate.getMonth()+'-'+currentdate.getFullYear();

//по умолчаанию дата текущая
    send_request('2017-06-01');
    $('.send_data').click(function () {
            gcw_handlerFDtbXg6kP.reload();
            $('#radio_cl').find(':radio[name=ch_currency][value="Rub"]').prop('checked', true);
            send_request($('#month').val() + '-01');
        }
    )
//смена курса валют
    $('input[type=radio][name=ch_currency]').change(function () {
        var usd_curr = 1;
        var temp_usd_curr = Math.round($('#gcw_valFDtbXg6kP1').val());
        if (this.value === 'Usd') {
            usd_curr = temp_usd_curr;
        }
        else if (this.value === 'Rub') {
            usd_curr = 1 / temp_usd_curr;
        }
        $('#table #salary').each(function () {
                var temp_sal = $(this).html() / usd_curr;
                $(this).html(temp_sal);
            }
        )
    })
    //новый сотрудник
    $('#close').click(function () {

        var str_new_assoc = $('#name_assoc').val() + ',' + $('#last_name_assoc').val() + ',' + $('#sel_prof').val() + ',' + $('#inp_salary').val() + ',' + $('#in_date').val();
        $.ajax({
            type: 'GET',
            url: 'index.php',
            data: {'new_assoc': str_new_assoc},
            success: function (result_p) {
                console.log(result_p);
                if (result_p == true) {
                    alert("Success");
                    var html_t = '';
                    var temp_date = $('#month').val() + '-01';
                    html_t = '<tr><td align="center">' + $('#name_assoc').val() + '</td><td align="center">' + $('#last_name_assoc').val() + '</td><td align="center">' + $('#sel_prof').val() + '</td><td  id="salary" width="5%" align="center">' + $('#inp_salary').val() + '</td><td align="center">' + 0 + '</td><td align="center"><a rel="lightbox-mygallery" href="' + '' + '"><img src="' + '' + '"</a>' + '</td><td align="center">' + temp_date + '</td></tr>';
                    $('#table > tbody').append(html_t);
                } else alert("Error");
            }
        });
    })
//подгрузка профессий из базы
    $('.button_active').click(
        update_prof($('#sel_prof'))
    )
//        button_active_prem
    $('.button_active_prem').click(
        update_prof($('#sel_prof_prem'))
    )
//выписать премию
    $('#close_prem').click(function () {
        var temp_date = $('#month').val() + '-01';
        var prem_bonus = $('#sel_prof_prem').val() + ',' + $('#prem_bonus').val() + ',' + temp_date;
        $.ajax({
            type: 'GET',
            url: 'index.php',
            data: {'prem_bonus': prem_bonus},
            success: function (result_p) {
                console.log(result_p);
                if (result_p == true) {
                    alert("Success");
                    send_request(temp_date);
                    gcw_handlerFDtbXg6kP.reload();
                } else alert("Error");
            }
        });
    })

});
//выбор месяца
function send_request(data) {
    $("tr").empty();
    $.ajax({
        type: 'GET',
        url: 'index.php',
        data: {'month': data},
        success: function (result) {
            var html = '<tr></tr><th>Имя</th><th>Фамилия</th><th>Должность</th><th>ЗП</th><th>Бонус</th><th>Фото</th><th>Дата</th></tr>';
            $.each($.parseJSON(result), function (index, element) {
                html += '<tr><td align="center">' + element.Worker_Name + '</td><td align="center">' + element.Worker_LastName + '</td><td align="center">' + element.Worker_Prof + '</td><td  id="salary" width="5%" align="center">' + element.Salary + '</td><td align="center">' + element.Bonus + '</td><td align="center"><a rel="lightbox-mygallery" href="' + element.Avatar + '"><img src="' + element.Avatar + '"</a>' + '</td><td align="center">' + element.Date_s + '</td></tr>';
            });
            $('#table > tbody').append(html);
        }
    });
}

//выборка профессий
function update_prof(id_sel) {
    var list_opt = id_sel;
    list_opt.empty();
    $.ajax({
        type: 'GET',
        url: 'index.php',
        data: {'prof': 'yes'},
        success: function (result_p) {
            console.log(result_p);
            var parser_res = $.parseJSON(result_p);
            $.each(parser_res, function (index, value) {
                list_opt.append(new Option(value, value));
            });
        }
    });
}
//</script>
