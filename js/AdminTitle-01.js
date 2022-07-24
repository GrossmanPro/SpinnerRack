$(document).ready( function () {
    $("#adminTitlesTable").DataTable();
    
    $(".deleteTitle").click(function() {
        var deleteConfirm = confirm("Do you want to delete this title?");
        if (deleteConfirm) {
            var titleId = this.id.split("_");
            $("#deleteId").val(titleId[1]);
            $("#titleDelete").submit();
        }
    });
    
});
