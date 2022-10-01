$(document).ready(function(){

})



function onlyNumericValue(ele) {

    $(ele).on("keypress", function (e) {
        if (isNaN(this.value + '' + String.fromCharCode(e.charCode))) return false;
    });
    $(ele).on("paste", function (e) {
        e.preventDefault();
    });
}

onlyNumericValue('#car_seat');
onlyNumericValue('#car_door');
onlyNumericValue('#car_passenger');

function deleteReservation(idReservation) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success m-3',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Etes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Non, Annuler!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url:"/apicar/reservation/delete",
                type:'GET',
                data:{
                    idReservation: idReservation
                },
                dataType:'json',
                success:function(data){
                   location.reload();
                }
            });
        }
    })


}

$(document).ready(function(){

});


function deleteClient(idClient) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success m-3',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url:"/apiclient/client/delete",
                type:'GET',
                data:{
                    idClient: idClient
                },
                dataType:'json',
                success:function(data){
                    location.reload();
                }
            });
        }
    })


}






$(document).ready(function(){

    var editor = new Quill('#editor', {
        modules: {
            'syntax': true,
            'toolbar': [
                [{ 'font': [] }, { 'size': [] }],
                [ 'bold', 'italic', 'underline', 'strike' ],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'super' }, { 'script': 'sub' }],
                [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
                [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
                [ 'direction', { 'align': [] }],
                [ 'link', 'image' ],
                [ 'clean' ]
            ]
        },

        placeholder: 'Votre Article...',
        theme: 'snow',
    });


    $("#post_title").keyup(function(e){
        let typedText = $(this).val();
        let sluggedText = slugifyInput(typedText);
        $("#post_slug").val(sluggedText);

    });

})

function slugifyInput(text) {

    const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;"
    const to = "aaaaaeeeeeiiiiooooouuuunc------"

    const newText = text.split('').map(
        (letter, i) => letter.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i)))

    return newText
        .toString()                     // Cast to string
        .toLowerCase()                  // Convert the string to lowercase letters
        .trim()                         // Remove whitespace from both sides of a string
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/&/g, '-and-')           // Replace & with 'and'
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-');        // Replace multiple - with single -
}



$(document).ready(function(){

    $('#reservation_save').removeAttr("type");
    $('#reservation_save').on('click',function (e) {
        e.preventDefault();



        const str = $('#custom').val();
        let from = str.split('to')[0];
        let to = str.split('to')[1];

        let startDate = moment(from, "YYYY.MM.DD");
        let endDate = moment(to, "YYYY.MM.DD");
        let daysNumber = endDate.diff(startDate, 'days');

        daysNumber = daysNumber+1;
        $('.daysNumber').val(daysNumber);

        const startTime = $('#startTime').val();
        const endTime   = $('#endTime').val();

        if(!checkEmtyField('endTime')){

            addErrorBorder('endTime');

        }else{
            removeErrorBorder('endTime');

            let selectedUser = $( "#reservation_client option:selected" ).val()
            let selectedCar = $( "#reservation_car option:selected" ).val()

            $.ajax({
                url:"/apicar/reservation/add/date",
                type:'GET',
                data:{
                    from: from,
                    to: to,
                    daysNumber: daysNumber,
                    startTime,
                    endTime,
                    selectedUser: selectedUser,
                    selectedCar: selectedCar
                },
                dataType:'json',
                success:function(data){

                    // TODO: Change this hard coded link later
                    let link = window.location.protocol + "//" + window.location.host;
                    console.log(link);
                    window.location.href = link+'/reservation/show?flash=reservation';
                }
            });




        }

    })
    $("#custom").flatpickr({

        enableTime: false,
        dateFormat: "Y-m-d",
        mode: "range",
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

    $("#startTime").flatpickr({

        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minTime: "09:00",
        maxTime: "20:00",

    });

    $("#endTime").flatpickr({

        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minTime: "09:00",
        maxTime: "20:00",

    });

    function numeroAdosCaracteres( fecha ) {
        if (fecha > 9){
            return ""+fecha;
        }else{
            return "0"+fecha;
        }
    }

    function checkEmtyField(inputId) {

        return $("#" + inputId).val().length > 0;

    }

    function addErrorBorder(inputId) {

        $("#" + inputId).addClass("error");
    }

    function removeErrorBorder(inputId) {
        $("#" + inputId).removeClass("error");
    }

    $( function () {

        let link = window.location.href.split("?")[1];

        if (link !== undefined){

            let after_ = link.substring(link.indexOf('=') + 1);
            let linkToCheck = "flash="+after_;

            if (link === linkToCheck){


                iziToast.success({
                    title: 'Ajoute success',
                    message: after_+' enregistrer avec success',
                });
                let newLink = window.location.href.split("?")[0];
                window.history.pushState("", "", newLink);
            }
        }

    });



})


function deleteReservation(idReservation) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success m-3',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Non, Annuler!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url:"/apicar/reservation/delete",
                type:'GET',
                data:{
                    idReservation: idReservation
                },
                dataType:'json',
                success:function(data){
                    location.reload();
                }
            });
        }
    })


}



$(document).ready(function() {



});
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
                alert(54);
                window.document.location = Routing.generate('search');
            }
        });


    })




    $( function () {

        let link = window.location.href.split("?")[1];
        if (link !== undefined){
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
