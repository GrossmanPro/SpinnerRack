$(document).ready( function () {
    $("#comicsListTable").DataTable();
    
    $(".deleteComic").click(function() {
        var deleteConfirm = confirm("Do you want to delete this comic?");
        if (deleteConfirm) {
            var comicId = this.id.split("_");
            $("#deleteId").val(comicId[1]);
            $("#comicDelete").submit();
        }
    });
    
});