$(document).ready(function () {


    $("#reservation-home").flatpickr({

        enableTime: false,
        dateFormat: "Y-m-d",
        mode: "range",
        locale: {
            rangeSeparator: ' à ',
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            },
            months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            },
        },
        minDate: "today",
        onChange: function (selectedDates, dateStr, instance) {



            let from = selectedDates[0].getFullYear() + "-" + numeroAdosCaracteres(selectedDates[0].getMonth() + 1) + "-" + numeroAdosCaracteres(selectedDates[0].getDate());
            let to = selectedDates[1].getFullYear() + "-" + numeroAdosCaracteres(selectedDates[1].getMonth() + 1) + "-" + numeroAdosCaracteres(selectedDates[1].getDate());



            //Calculate date here
            let startDate = moment(from, "YYYY.MM.DD");
            let endDate = moment(to, "YYYY.MM.DD");

            let daysNumber = endDate.diff(startDate, 'days');
            daysNumber = daysNumber + 1;


            $('.daysNumber').val(daysNumber);

        }

    });


    $('#search').on('click',function (e) {

        const str = $('#reservation-home').val();
        let from = str.split('à')[0];
        let to = str.split('à')[1];

        let startDate = moment(from, "YYYY.MM.DD");
        let endDate = moment(to, "YYYY.MM.DD");
        let daysNumber = endDate.diff(startDate, 'days');

        daysNumber = daysNumber+1;
        $('.daysNumber').val(daysNumber);

        console.log(from,to);
        $.ajax({
            url:"/apicar/home/search",
            type:'GET',
            data:{
                from: from,
                to: to,
                daysNumber: daysNumber,
            },
            dataType:'json',
            success:function(data){

                // TODO: Change this hard coded link later
                window.location.href = 'http://127.0.0.1:8001/reservation/show?flash=reservation';
            }
        });


    })




    $( function () {

        let link = window.location.href.split("?")[1];
        let after_ = link.substring(link.indexOf('=') + 1);
        let linkToCheck = "flash="+after_;

        if (link === linkToCheck){

            console.log(after_);
            after_ = after_.replace(/\//g, ' ');
            console.log(after_);

            iziToast.success({
                title: 'Ajoute success',
                message: after_,
            });
            let newLink = window.location.href.split("?")[0];
            window.history.pushState("", "", newLink);
        }

    });

    function numeroAdosCaracteres( fecha ) {
        if (fecha > 9){
            return ""+fecha;
        }else{
            return "0"+fecha;
        }
    }

})
