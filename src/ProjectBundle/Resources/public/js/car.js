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