$(document).ready(function() {

    table = $('#DataTables_Table_0').DataTable();

    table.destroy();

   
    table = $('#DataTables_Table_0').DataTable( {
        dom: 'Blfrtip',
        columnDefs: [
            {
                targets: 4, 
                className: 'noVis'           
            }    
        ],
      
        
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Tất cả"] ],
         "language": {
            "lengthMenu": "Hiển thị: _MENU_ đối tượng",
            "search": "Tìm kiếm _INPUT_",
            'info':"",
            "zeroRecords": "Không tìm thấy dữ liệu",
            "infoEmpty": "Không có dữ liệu hợp lệ",
            "infoFiltered": "(Lọc từ _MAX_ dữ liệu)",
            "paginate": {
              "first":      "Đầu tiên",
              "last":       "Cuối cùng",
              "next":       "Tiếp theo",
              "previous":   "Trước đó"
          },
           buttons: {
                colvis: 'Thay đổi số cột'
            }
        },

       buttons: [
             
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            },
       
            {
                extend: 'copyHtml5',
                exportOptions: {
                     columns: [ 0,1,2,3]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                     columns: [ 0,1,2,3]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0,1,2,3]
                }
            },
            
        ],
      

    } );
  $('#DataTables_Table_0_wrapper').addClass('d-flex row');
  $('#DataTables_Table_0_length').addClass('mt-2');
  $('#DataTables_Table_0_filter').addClass('mt-2');

} );