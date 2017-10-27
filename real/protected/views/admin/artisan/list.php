<div  class="container-fluid">

    <form id="musform"  >

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="input-group">
                <span class="input-group-addon" >表名称</span>
                <input type="text" name="tname" class="form-control tname" placeholder="表名称" aria-describedby="basic-addon1">
            </div>
            <div class="input-group">
                <span class="input-group-addon" >表描述</span>
                <input type="text" name="china" class="form-control tname" placeholder="描述" aria-describedby="basic-addon1">
            </div>
            <button id="getinfo" class="btn btn-info">获取表结构</button>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="checkbox tnamelist">

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
             <div class="row">
                <div class="col-xs-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">控制器名称</span>
                        <input type="text" name="conname" class="form-control" placeholder="控制器名称" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">控制器继承类名</span>
                        <input type="text" name="conextends" class="form-control" placeholder="控制器继承类名" aria-describedby="basic-addon1">
                    </div>

                </div>

                 <div class="col-xs-8">
                     <div class="input-group type-group">
                         <span class="input-group-addon" >获取数据的表名</span>
                         <input type="text" name="type[arr][0]" class="form-control" placeholder="获取数据的表名" aria-describedby="basic-addon1">
                         <span class="input-group-addon" >获取数据的server</span>
                         <input type="text" name="type[arr][1]" class="form-control" placeholder="获取数据的server" aria-describedby="basic-addon1">
                         <span class="input-group-addon" >获取数据方法</span>
                         <input type="text" name="type[arr][2]" class="form-control" placeholder="获取数据的方法" aria-describedby="basic-addon1">
                     </div>

                     <button class="btn btn-info addtype">添加读取数据类型</button>
                 </div>





        </div>
    </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">控制器添加方法必须参数</div>
        <div class="panel-body">
            <div class="checkbox collist-one">

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">控制器更新方法必须参数</div>
        <div class="panel-body">
            <div class="checkbox collist-two">

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">SERVER名称</span>
                        <input type="text" name="servername" class="form-control" placeholder="SERVER名称" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">SERVER继承类名</span>
                        <input type="text" name="serverextends" class="form-control" placeholder="SERVER继承类名" aria-describedby="basic-addon1">
                    </div>

                </div>
                </div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon" >MODEL名称</span>
                        <input type="text" name="modelname"  class="form-control" placeholder="MODEL名称" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon" >MODEL继承类名</span>
                        <input type="text" name="modelextends" class="form-control" placeholder="MODEL继承类名" aria-describedby="basic-addon1">
                    </div>

                </div>
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon" >去除表前缀的SQL表</span>
                        <input type="text" name="tablecasename" class="form-control" placeholder="去除表前缀的SQL表" aria-describedby="basic-addon1">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-success btn-block goup">立即生成</button>

    </form>

    </div>


    <script>

        $(function(){

            $('.goup').click(function(e){
                e.preventDefault();
                var musform = new FormData(document.getElementById("musform"));
                $.ajax({
                    url:"<?php echo U('admin/artisan/start')?>",
                    type:"post",
                    data:musform,
                    processData:false,
                    contentType:false,
                    success:function(data){
                         if(data.code==0)
                        alert("生成成功！！"+obj.msg);
                    },
                    error:function(e){
                        alert("代码提交错误！！");
                    }
                });

            });


            typekey=2;
            $('.addtype').click(function (e) {

                e.preventDefault();

                type_str='<div class="input-group ">'+
                    '<span class="input-group-addon" >获取数据的表名</span>'+
                    '<input type="text" name="type[arr'+typekey+'][0]" class="form-control" placeholder="获取数据的表名" aria-describedby="basic-addon1">'+
                    '<span class="input-group-addon" >获取数据的server</span>'+
                    '<input type="text" name="type[arr'+typekey+'][1]" class="form-control" placeholder="获取数据的server" aria-describedby="basic-addon1">'+
                    '<span class="input-group-addon" >获取数据方法</span>'+
                    '<input type="text" name="type[arr'+typekey+'][2]" class="form-control" placeholder="获取数据的方法" aria-describedby="basic-addon1">'+
                    '</div>';
                $('.type-group').after(type_str);
                typekey++;
            });




            $('#getinfo').click(function(e){
e.preventDefault();
                tname = $('.tname').val();

                $.get("<?php echo U('admin/artisan/gettree')?>",
                    {
                        tname:tname
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 666){
                            console.log(obj.result);
                            tnamelist_str ='';
                            collist_one_str='';
                            collist_two_str='';
                            for(key in obj.result){
                                tnamelist_str+='  <label class="checkbox-inline">'+
                                    '<input type="checkbox" checked name="tnameval[]" value="'+obj.result[key][1]+'"> <span style="color:red">'+obj.result[key][1]+'</span>'+' <span>'+obj.result[key][0]+'</span>'+' <span>'+obj.result[key][2]+'</span>'+
                                    '</label>';
                                collist_one_str+='  <label class="checkbox-inline">'+
                                    '<input type="checkbox" checked name="coloneval[]" value="'+obj.result[key][1]+'"> <span style="color:red">'+obj.result[key][1]+'</span>'+' <span>'+obj.result[key][0]+'</span>'+' <span>'+obj.result[key][2]+'</span>'+
                                    '</label>';
                                collist_two_str+='  <label class="checkbox-inline">'+
                                    '<input type="checkbox" checked name="coltwoval[]" value="'+obj.result[key][1]+'"> <span style="color:red">'+obj.result[key][1]+'</span>'+' <span>'+obj.result[key][0]+'</span>'+' <span>'+obj.result[key][2]+'</span>'+
                                    '</label>';


                            }

                            $('.tnamelist,.collist-one,.collist-two').empty();
                            $('.tnamelist').append(tnamelist_str);
                            $('.collist-one').append(collist_one_str);
                            $('.collist-two').append(collist_two_str);

                        }else{
                            alert('失败');
                        }

                    });



            })



        });








    </script>