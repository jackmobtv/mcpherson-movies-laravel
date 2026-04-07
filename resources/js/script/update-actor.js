$(document).on("click", ".open-modal", function() {
    let id = $(this).data('id');
    let name = $(this).data('name')
    console.log(name);
    console.log(id);
    $(".modal-body #id").val(id);
    $(".modal-body #name").val(name);
});
