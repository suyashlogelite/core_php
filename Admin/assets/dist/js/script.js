// $(document).on('submit','#myForm',function(e){
//     e.preventDefault();

//     $.ajax({
//     method:"POST",
//     url: "../backend/database.php",
//     data:$(this).serialize(),
//     success: function(data){
//         console.log(data);
//     if(data === 'admin') {
//         window.location = "../index.php";
//     }
//     else {
//         console.log(data);
//         $('#msg').html(data).removeClass("d-none");
//         $('#myForm').find('input').val('');
//     }
//     }});
// });
