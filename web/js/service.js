
    function sendId(id, problem, weidth, komplekt, dep_id){
        $("#cartridgesendform-cartridge_id").val(id);
        $("#cartridgesendform-problem").val(problem);
        $("#cartridgesendform-weidth").val(weidth);
        $("#cartridgesendform-komplekt").val(komplekt);

        var url = '/departaments/get-departament';
        $.get(url,
            {'id': dep_id},
            function (data){
                $("#select2-cartridgesendform-departament_id-container").html(data['results'].text);
            }
        );


    };

    function getId(id, works, weidth, komplekt){
        $("#cartridgegetform-cartridge_id").val(id);
        $("#cartridgegetform-works").val(works);
        $("#cartridgegetform-weidth").val(weidth);
        $("#cartridgegetform-komplekt").val(komplekt);
    };

    function saveToBasket(){
        $("#cartridge_service").on("pjax:end", function(){
            $("#service_modal").modal("hide");
//$.pjax.reload('#get-basket',{cache: false});
            $.pjax.reload('#cartridge_select',{cache: false});
        });

    };

