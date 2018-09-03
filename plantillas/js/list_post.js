
    var table = $('#list_post_table').DataTable({
        "autoWidth": false,
        "language": {
            "url": baseurl +"plantillas/js/post_spanish.json"
        },
        'lengthMenu':[[10,25,50,-1],[10,25,50,"Todo"]],
        'pagingType': "full_numbers",
        'paging':true,
        'info': true,
        'filter':true,
        'stateSave':true,
        'processing':true,
        'serverSide':true,
        'ajax' : {
            'url': baseurl+"blog/get_list_post",
            'dataType': "json",
            'type': "POST",
            'data': {}
        },
        'columns':[
            {data: 'id_post'},
            {data: 'titulo'},
            {data: 'tema'},
            {data: 'fecha'},
            {data: 'enlace'},
            {data: 'descripcion'},
            {"orderable":true,
                 render:function(data,type,row) {
                    var addHtml = `
            <h2 class="mb-0"><a style="color:#003783;" href="`+baseurl+`post/`+row.enlace+`">`+row.titulo+`</a></h2>
            <span class="text-muted"><strong>Publicado hace:</strong> `+row.fecha+`&nbsp;atras.</span>
                <div class="mt-2">
                <p>`+row.descripcion+`</p> 
                <a href="`+baseurl+`post/`+row.enlace+`" class="btn btn-primary" style="background-color:#003783">Leer mas</a>
                </div>`;
                return addHtml;
    
                }
            }
        ],
        'columnDefs': [
            {
                'targets': [0],
                'visible': false,
                'searchable':false
            },
            {
                'targets': [1],
                'visible': false,
                'searchable':false
            },
            {
                'targets': [2],
                'visible': false,
                'searchable':false
            },
            {
                'targets': [3],
                'visible': false,
                'searchable':false
            },
            {
                'targets': [4],
                'visible': false,
                'searchable':false
            },
            {
                'targets': [5],
                'visible': false,
                'searchable':false
            }
       
        ],
        "order": [[ 6, "desc" ]]
    });
    
    