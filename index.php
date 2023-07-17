<?php
include("header.php");
?>
<div class="container">
    <span id="no_data_found" class="no_data_found">No Records In DB, Please use the refresh button to load in database.</span>
    <button type="button" class="btn btn-primary" id="refresh">Refresh</button>

    <div class="row">
        <div class="col-md-12">
            <span id="totalRecords"> </span>
            <table class="table resultTable">
                <thead>
                <tr>
                    <th scope="col">Sl</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Number Of Stars</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody id="result">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        getDataFromDB();
        $("#refresh").on('click', function(e){
            e.preventDefault();
            $.get("fetchfromgit.php",
                {},
                function(data, status){
                    if(data.status=="200") {
                        getDataFromDB();
                        $(".no_data_found").attr("style", "display:none");
                    } else {
                        $(".no_data_found").attr("style", "display:block");
                        $("#no_data_found").text("Error on fetching data");
                    }
                });
        });
    });
    function getDataFromDB(){
        $.get("search.php",
            {},
            function(data, status){

                var trappend = "";
                console.log(data);
                if(data.status=="200") {
                    var sl= 1;
                    $.each(data.message, function (key, value) {
                        trappend = trappend + "<tr><td>"+ sl +"</td><td>" + value[1] + "</td><td>" + value[2] + "</td><td><a href='viewrepodetails.php?id=" + value[0] + "' target='_blank'>Details</a></td></tr>";
                        sl++;
                    });
                    $("#totalRecords").html("Total Records : "+ (sl-1));
                    $("#result").empty();
                    $("#result").append(trappend);
                    $(".resultTable").attr("style", "display:block");
                } else {
                    $(".no_data_found").attr("style", "display:block");
                    $("#no_data_found").text(data.message);
                }
            });
    }
</script>

<?php
include("footer.php");
?>
