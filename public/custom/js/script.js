$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const app_url =  $('meta[name="app-url"]').attr('content');
// DELETE ITEM
$('.options .delete').on('click', function(){
    $url = $(this).data('url');
    var jc = $.confirm({
        title: 'Delete Confirmation',
        content: 'Are you sure you want to delete this item?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            cancel: function () {
            },
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-red',
                action: function(){
                    jc.showLoading();
                    $.ajax({
                        url: $url,
                        type: 'DELETE',
                        success: function(result) {
                            
                        },
                        complete: function (data) {
                            window.location.reload();
                        }
                    });
                }
            }
        }
    });
})



// PUBLISH FEATURED
$('.ticker-option').on('click', function(){
    $td = $(this).closest('td');
    $val = $(this).data('val');
    $table = $(this).data('table');
    $type = $(this).data('type');
    $id = $(this).data('id');

    $td.find('*').hide();
    $td.append("<img src='/img/spinner.gif' style='width: 25px'>")
    $.ajax({
        url: app_url+'/shortcut-publish',
        type: "post",
        data: "table="+$table+"&type="+$type+"&id="+$id+"&value="+$val,
        success: function(d) {
            window.location.reload();
        }
    })
})

// FILTER
$('.filter').on('click', function(){
    var target = $(this).data('target');
    var jc = $.confirm({
        title: 'Filter',
        content: $(target).html(),
        type: 'default',
        typeAnimated: true,
        buttons: {
            close: {
                text: 'close',
                btnClass: 'btn-default',
                action: function(){
                    
                }
            },
            reset: {
                text: 'Reset',
                btnClass: 'btn-default',
                action: function(){
                    jc.$content.find('input, textarea, select').val('');
                    jc.$content.find("option:selected").removeAttr("selected");
                    return false;
                }
            },
            confirm: {
                text: 'Apply Filter',
                btnClass: 'btn-primary',
                action: function(){
                    jc.showLoading();
                    jc.$content.find('form').submit();
                }
            }
        }
    });
})

// SHOW STOCKS
$('.view-stocks').on('click', function(){
    var id = $(this).data('id');
    var name = $(this).data('name');
    var wh = $(this).data('wh');
    var jc = $.confirm({
        title: name,
        content: 'url: /item/'+id+"?wh="+wh,
        columnClass: 'col-md-8 col-md-offset-2',
        type: 'default',
        typeAnimated: true,
        onContentReady: function () {
            jc.$content.find(".edit-stock-btn").on('click', function(){
                $(this).addClass('d-none');
                $(this).closest('tr').find('.stock-input').prop('disabled', false);
                $(this).closest('tr').find('.save-stock-btn').removeClass('d-none');
            });
            
            jc.$content.find(".save-stock-btn").on('click', function(){
                $ths = $(this);
                $id = $ths.data('id');
                $stock = $ths.closest('tr').find('.stock-input').val();
                jc.showLoading();
                $.ajax({
                    url: 'item/save_stock',
                    type: 'post',
                    data: {id:$id, stock:$stock},
                    error: function () {
                        toastr.error("Something went wrong please try again", 'Error!')
                        jc.hideLoading();
                        $ths.addClass('d-none');
                        $ths.closest('tr').find('.stock-input').prop('disabled', true);
                        $ths.closest('tr').find('.edit-stock-btn').removeClass('d-none');
                    },
                    success: function (r) {
                        if (r.success) {
                            jc.hideLoading();
                        } else {
                            toastr.error(r.error, 'Error!')
                        }
                        $ths.addClass('d-none');
                        $ths.closest('tr').find('.stock-input').prop('disabled', true);
                        $ths.closest('tr').find('.edit-stock-btn').removeClass('d-none');
                    }
                });

            });

        },
        buttons: {
            close: {
                text: 'close',
                btnClass: 'btn-default',
                action: function(){
                    
                }
            },
            print: {
                text: 'print',
                btnClass: 'btn-primary',
                action: function(){
                    $table = jc.$content;

                    $css = "<style>"+
                    "table{ width: 100%;border-collapse: collapse; }"+
                    "table, td, th{ border: 1px solid #ddd }"+ 
                    "th, td{ padding: 10px}"+       
                    "</style>";
                    var myWindow=window.open('','','width=800,height=600');
                    myWindow.document.write($css+"<h1>"+name+"</h1>"+$table.html());
                    myWindow.document.close();
                    myWindow.focus();
                    myWindow.print();
                    myWindow.close();

                    return false;
                }
            }
        }
    });
})

// IN OUT
$('.in-out').on('click', function(){
    var id = $(this).data('id');
    var name = $(this).data('name');
    var v = $(this).data('val');
    var jc = $.confirm({
        title: name,
        content: 'url: /item/in_out/'+id+"?type="+v,
        // columnClass: 'col-md-6 col-md-offset-3',
        type: (v=='in')?'green':'red',
        typeAnimated: true,
        buttons: {
            close: {
                text: 'close',
                btnClass: 'btn-default',
                action: function(){
                    
                }
            },
            submit: {
                text: 'submit',
                btnClass: 'btn-primary',
                action: function(){
                    // jc.$content.find('form').submit();
                    busy(true)
                    $.ajax({
                        url: 'item/save_in_out',
                        type: 'post',
                        data: jc.$content.find('form').serialize(),
                        error: function () {
                            $.alert("Something went wrong please try again");
                            busy(false)
                        },
                        success: function (r) {
                            if (r.success) {
                                window.location.reload();
                            } else {
                                toastr.error(r.error, 'Error!')
                            }
                            busy(false)
                        }
                    });
                }
            }
        }
    });
})



// ADD FORM
$('.save-form').on('click', function(){
    const form = $(this).data('target');
    var status = $(this).data('status');
    var callback = $(this).data('callback');
    $(form).find("[name='status']").val(status)
    if(validate($(form))){
        
        busy(true)
        var mform = new FormData(jQuery($(form))[0]);
        $url = $(form).data('url');
        $.ajax({
            url: $url,
            type: 'post',
            data: mform,
            cache: false,
            async: true,
            processData: false,
            contentType: false,
            progress: function (a) {
            },
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function (evt) {
                    var w = parseInt(evt.loaded / evt.total * 100);
                };
                xhr.upload.onload = function (d) {
                    // $('.totalc').text(d);e
                };
                return xhr;
            },
            error: function () {
                $.alert("Something went wrong please try again");
                busy(false)
            },
            success: function (r) {
                if (r.success) {
                    if(r.new_window){
                        printOR(r.new_window)
                    }
                    
                    window.location.href = callback;
                } else {
                    toastr.error(r.error, 'Error!')
                }
                busy(false)
            }

        });

    }
})

// ADD FORM
$('.update-form').on('click', function(){
    const form = $(this).data('target');
    var status = $(this).data('status');
    var callback = $(this).data('callback');
    $(form).find("[name='status']").val(status)
    if(validate($(form))){
        
        busy(true)
        var mform = new FormData(jQuery($(form))[0]);
        $url = $(form).data('url');
        $.ajax({
            url: $url,
            type: 'post',
            data: mform,
            cache: false,
            async: true,
            processData: false,
            contentType: false,
            progress: function (a) {
            },
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function (evt) {
                    var w = parseInt(evt.loaded / evt.total * 100);
                };
                xhr.upload.onload = function (d) {
                    // $('.totalc').text(d);e
                };
                return xhr;
            },
            error: function () {
                $.alert("Something went wrong please try again");
                busy(false)
            },
            success: function (r) {
                if (r.success) {
                    window.location.href = callback;
                } else {
                    toastr.error(r.error, 'Error!')
                }
                busy(false)
            }

        });

    }
})

// REMOVE ITEM
$('body').on('click', '.remove-item', function(){
    $(this).closest('.parent').remove();
    computeAll(false);
})

$('.add-item').on('click', function(){
    $dataval = $(this).data('val');
    $model = $('.field-types').find($dataval).clone();
    console.log($model)
    $model.find("textarea").addClass('editor');
    $model.find(".colorpick").addClass('colorpicker');
    $model.show();
    $model.removeClass('model');
    $(".append-here").append($model);
    $model.find('.drpdwn2').select2();
    fixElements();
})


$('body').on('click', '.add-subitem', function(){
    $model = $('.field-types').find('.subitem-model').clone();
    console.log($model)
    $model.find("textarea").addClass('editor');
    $model.find(".colorpick").addClass('colorpicker');
    $model.show();
    $model.removeClass('model');
    $(this).closest('.parent').find(".subitem-containter").append($model);
    fixElements();
})


$('.page_type').on('change', function(){
    getPageType();
});

fixElements();



$('.checkall').on('change', function(){
    if ($(this).is(':checked')) {
        $(this).closest('tr').find('.checker').prop('checked', true);
    }else{
        $(this).closest('tr').find('.checker').prop('checked', false);
    }
})



function getPageType(){
    $type = $('.page_type').val();
    $url =  $('.page_type').data('url');
    $(".type_id option").remove();
    // $.ajax({
    //     url: $url,
    //     type: 'POST',
    //     data: {'type': $type},
    //     dataType:'json',
    //     success: function(result) {
    //         if(result){
    //             $(".type_id").append("<option value=''> -- Select Page Target -- </option>");
    //             $.each(result, function( i, v ) {
    //                 $sltd = (v.id == $(".type_id").data('val'))?'selected':'';
    //                 $(".type_id").append("<option value='"+v.id+"' "+$sltd+">"+v.title+"</option>");
    //             })
    //         }
    //     },
    //     complete: function (data) {
    //         // window.location.reload();
    //     }
    // });
}




function busy(tf){
    if(tf)
        $('.busy').removeClass('d-none')
    else
        $('.busy').addClass('d-none')
}

function validate(form){
    let result = true;
    $(form).find('input, textarea, select').each(function(){
        if($(this).prop('required') && $(this).val() == ''){
            result = false;
            $(this).closest('.form-group').addClass('has-error')

            $tab = $(this).closest('.tab-pane').attr('id');
            $(".nav-item a[href='#"+$tab+"']").css('color', 'red')
        }else{
            $(this).closest('.form-group').removeClass('has-error')
            
            $tab = $(this).closest('.tab-pane').attr('id');
            $(".nav-item a[href='#"+$tab+"']").css('color', 'none')
        }
    })
    return result;
}


function scrollDown(){
    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
}

function readIMG(input, $img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $img.attr('src', e.target.result)
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function loadEditor(){
    $('body').find(".editor:visible").each(function(){
        $dh = $(this).data('height');
        $dh = ($dh != '')?$dh:300;
        $(this).summernote({
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'video']],
              ['view', ['fullscreen', 'codeview', 'help']],
            ],
            height: $dh,
            tabsize: 2,
            callbacks: {
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });
    })  
}

function loadColorPicker(){
    $('body').find(".colorpicker:visible").each(function(){
        $dh = $(this).data('height');
        $dh = ($dh != '')?$dh:300;
        $(this).spectrum({
            type: "component"
        });
    })  
}


function fixSorting(){
    $("body").find('#sortable .parent').each(function(){
      var i = $(this).index();
      $(this).find(".sortField").val(i);
    });
}

function selectImage(t, url){
    $ext = $(t).val().split('.').pop();
    $parent = $(t).closest('.parent');
    if($ext=='mp4' || $ext=='webm' || $ext=='ogg'){
        $parent.find('img').hide();
        $parent.find('.playMe').show();
        $parent.find('.playMe').data('value', url);
    }else{
        $parent.find('.playMe').hide();
        $parent.find('img').show();
        $parent.find('img').attr('src', url);
    }
}


function fixElements(){
    $imgC=0;$vidC=0;
    $("body").find(".fields-here .image-input").each(function(){
        $contID = $(this).closest('.parent').find("[name='content_id[]']").val();
        if($(this).val() != ''){
            $imgC++;
            $exist_check = ($contID > 0)?'_exist_':'';
            $(this).attr("name", "image"+$exist_check+$imgC+"[]");
        }
    });
    $("body").find(".fields-here .video-input").each(function(){
        if($(this).val() != ''){
            $vidC++;
            $(this).attr("name", "video"+$vidC+"[]");
        }
    });

    loadEditor();
    loadColorPicker();
    fixSorting();
    fixElementNames();
}

function fixElementNames(){
    $("#main-form").find('.parent-container').each(function(){
        var c = $(this).index();
        $(this).find('input, select, textarea').each(function(){
            $inputName = $(this).attr('name');
            if(typeof $inputName !== 'undefined') {
                $id = $inputName.replace("[c]", "["+c+"]");
                $(this).attr('name', $id);
            }
        })
        
        $(this).find('.item-containter').each(function(){            
            var i = $(this).index();
            console.log(i)
            $(this).find('input, select, textarea').each(function(){
                $inputName = $(this).attr('name');
                if(typeof $inputName !== 'undefined') {
                    $id = $inputName.replace("[i]", "["+i+"]");
                    $(this).attr('name', $id);
                }
            });
        });

    });
}


// INIT HERE
getPageType();
loadEditor();
$('.drpdwn').select2();
$(".nav-item").on('click', function(){
    setTimeout(() => {            
        loadEditor();
        fixElements();
    }, 100);
});
$('.colorpicker').spectrum({
    type: "component"
});

computeAll(false);
$("body").on('change', '.item-dropdown', function(){
    computeAll();
});
$("body").on('change', '.item-price, .item-qty', function(){
    computeAll(false);
});

function computeAll(change_price=true){
    $total = 0;
    $(".append-here").find('.item-dropdown').each(function(){
        
        if(change_price){
            $old_price = $(this).find('option:selected').data('price');
            $(this).closest('tr').find('.item-price').val($old_price);
        }
        
        $price = $(this).closest('tr').find('.item-price').val();
        $qty = $(this).closest('tr').find('.item-qty').val();
        $item_total = $price * $qty;
        $total += +$item_total;
        $(this).closest('tr').find('.item-total').html(number_format($item_total, 2));
    })

    $('.total').html(number_format($total, 2));
}



function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function printOR(url, title) {
    window.open(url, title, "width=800,height=600");
}