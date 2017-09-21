<?php include $this->admin_tpl("header"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/haidaoblue/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH;?>EasyUI/themes/icon.css">
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/jquery.easyui.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>EasyUI/hd_default_config.js"></script>
<style type="text/css">
    .textbox .textbox-text{text-align: center;}
</style>
<div class="content">
    <div class="site">
         <a href="<?php echo U('Activity/edit',array('id'=>"$id"))?>">活动管理</a> > 新增商品
    </div>
    <span class="line_white"></span>
    <div class="goods mt10">
        <div class="goods mt10">
            <div class="login mt10" style="border: none;">
                <table id="product_band_lists" style="width:100%"></table> 
            </div>
            <div class="clear"></div>
            <?php include $this->admin_tpl('copyright') ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--表格js-->
    <script type="text/javascript">
    var dom = $('#product_band_lists');
    var pageSize = <?php echo PAGE_SIZE?>;
    var dataurl = '<?php echo U('goodsList',array('id'=>"$id",'cid'=>"$cid"))?>';
    var addurl = '<?php echo U('goodsAdd',array('id'=>"$id",'cid'=>"$cid"))?>';
    var editurl = '<?php echo U('goodsEdit',array('id'=>"$id",'cid'=>"$cid"))?>';
    var delurl = '<?php echo U('ajax_del')?>';
    var statusurl = '<?php echo U('ajax_status')?>';
    var sorturl = '<?php echo U('ajax_sort')?>';
    $(function(){   
        dom.datagrid({   
            url:dataurl, 
            striped:true,
            width:'100%',
            fitColumns:true,
            checkOnSelect:true,
            toolbar:[
                {
                    id:'addrow',
                    text:'添加',
                    iconCls:'icon-add'
                },'-'
            ],
            frozenColumns:[[
                {field:'id',checkbox:true}
            ]],
            pagination:true,
            pageSize:pageSize,
            pageList: [pageSize,pageSize*2,pageSize*4],//可以设置每页记录条数的列表 
            columns:[[
                {field:'aid',title:'活动ID',hidden:true},
                {field:'cid',title:'部件ID',hidden:true},
                {field:'name',title:'商品标题',width:'10%',halign:'center',align:'center'},
                {field:'cname',title:'所属部件',width:'10%',align:'center',sortable:true},
                {field:'addtime',title:'上传时间',width:'10%',align:'center',sortable:true,
                    formatter:function(value,row,index){  
    //                                    alert(value);
                        return $.fn.datebox.defaults.timeformat(value);
                    }
                },
                {field:'gid',title:'关联产品ID',width:'10%',align:'center',sortable:true},
                {field:'bname',title:'所属品牌',width:'10%',align:'center',sortable:true},
                {field:'url',title:'品牌网址',width:'20%',align:'center',sortable:true},
                {field:'is_show',title:'是否显示',width:'5%',halign:'center',align:'center',sortable:true,
                    formatter:function(value,row,index){
                        if (value == 1){
                            statushtml = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_on" ></span>';
                        }else{
                            statushtml = '<span url="'+statusurl+'&id='+row.id+'" class="ajax-get ajax_off" ></span>';
                        }
                        return statushtml;
                    }
                },                
                {field:'sort',title:'品牌排序',width:'10%',align:'center',sortable:true,
                    formatter:function(value,row,index){
                        return '<input name="sort" class="easyui-numberspinner sort" style="width:80px;" required="required" data-options="min:0,editable:true" value="'+value+'" data-id="'+row.id+'">';
                    }
                },
                {field:'none',title:'操作',width:'15%',halign:'center',align:'center',
                    formatter:function(value,row,index){
                        var edithtml = '<a href="'+editurl+'&id='+row.id+'">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;';
                        var delhtml = '<a onclick=batch('+row.id+')>删除</a>';
                        return edithtml + delhtml;
                    }
                }
            ]],
            onLoadSuccess:function(data){
                $('.sort').numberspinner({
                    onChange:function(nvalue,ovalue){
                        var id = $(this).attr('data-id');
                        ChangeSort(id,nvalue);
                    }
                });
                $('.datagrid-btable td[field="sort"]').each(function(){
                    $(this).click(function(){
                        return false;
                    });
                })
            }
        });
        //修改排序
        function ChangeSort(id,val){
            $.messager.progress();
            $.getJSON(sorturl, {"id": id,"val": val}, function(data) {
                $.messager.progress('close');
            })
        }
        //添加
        $('#addrow').bind('click', function(){
            window.location.href=addurl;
        })
        
    });
       function batch(row){
            $.messager.confirm('确认','您确认想要删除所选择分类吗？',function(r){
                if(r){
                    window.location = delurl+'&id='+row;
                }
            })
        }
</script>