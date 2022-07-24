$(document).ready( function () {
    $("#adminPublishersTable").DataTable();
    
    $(".deletePublisher").click(function() {
        var deleteConfirm = confirm("Do you want to delete this publisher?");
        if (deleteConfirm) {
            var creatorId = this.id.split("_");
            $("#deleteId").val(creatorId[1]);
            $("#publisherDelete").submit();
        }
    });
    
});
