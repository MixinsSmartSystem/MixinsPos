// (function startApp() {
//     createResizeHandles();
// })();
//
// var currentHandleEl;
// var currentHandleOffset;
//
// function createResizeHandles() {
//     var colHeaders = document.querySelectorAll('.col-header');
//     var resizeHandles;
//
//     for (let i = 0; i < colHeaders.length-1; i++) {
//         var tmpHandle = document.createElement('span');
//         tmpHandle.classList.add("col-handle");
//         colHeaders[i].appendChild(tmpHandle);
//
//         var resizeHandles = document.querySelectorAll('.col-handle');
//
//         resizeHandles[i].addEventListener('mousedown', function() {
//             currentHandleEl = this.parentNode;
//             currentHandleOffset = currentHandleEl.offsetWidth - event.pageX;
//             //console.log(colHeaders[i].innerHTML)
//         });
//     }
//
//     document.addEventListener('mousemove', function(e) {
//         currentHandleEl.style.width = currentHandleOffset + e.pageX + 'px';
//     });
//
//     document.addEventListener('mouseup', function(e) {
//         currentHandleEl = undefined
//     });
// }
//
//
// $(document).ready(function() {
//     zebraRows('tr:odd td', 'odd');
//
//     $('tbody tr').hover(function(){
//         $(this).find('td').addClass('hovered');
//     }, function(){
//         $(this).find('td').removeClass('hovered');
//     });
//
//     //default each row to visible
//     $('tbody tr').addClass('visible');
//
//     $('thead th').addClass('sortable')
//
//
//
//
//     //overrides CSS display:none property
//     //so only users w/ JS will see the
//     //filter box
//     $('#search').show();
//
//     $('#filter').keyup(function(event) {
//         //if esc is pressed or nothing is entered
//         if (event.keyCode == 27 || $(this).val() == '') {
//             //if esc is pressed we want to clear the value of search box
//             $(this).val('');
//
//             //we want each row to be visible because if nothing
//             //is entered then all rows are matched.
//             $('tbody tr').removeClass('visible').show().addClass('visible');
//         }
//
//         //if there is text, lets filter
//         else {
//             filter('tbody tr', $(this).val());
//         }
//
//         //reapply zebra rows
//         $('.visible td').removeClass('odd');
//         zebraRows('.visible:even td', 'odd');
//     });
//
//     //grab all header rows
//     $('.sortTable thead th').each(function(column) {
//         $(this).addClass('sortable')
//             .click(function(){
//                 var findSortKey = function($cell) {
//                     return $cell.find('.sort-key').text().toUpperCase() + ' ' + $cell.text().toUpperCase();
//                 };
//
//                 var sortDirection = $(this).is('.sorted-asc') ? -1 : 1;
//
//                 //step back up the tree and get the rows with data
//                 //for sorting
//                 var $rows		= $(this).parent()
//                     .parent()
//                     .parent()
//                     .find('tbody tr')
//                     .get();
//
//                 //loop through all the rows and find
//                 $.each($rows, function(index, row) {
//                     row.sortKey = findSortKey($(row).children('td').eq(column));
//                 });
//
//                 //compare and sort the rows alphabetically
//                 $rows.sort(function(a, b) {
//                     if (a.sortKey < b.sortKey) return -sortDirection;
//                     if (a.sortKey > b.sortKey) return sortDirection;
//                     return 0;
//                 });
//
//                 //add the rows in the correct order to the bottom of the table
//                 $.each($rows, function(index, row) {
//                     $('tbody').append(row);
//                     row.sortKey = null;
//                 });
//
//                 //identify the column sort order
//                 $('th').removeClass('sorted-asc sorted-desc');
//                 var $sortHead = $('th').filter(':nth-child(' + (column + 1) + ')');
//                 sortDirection == 1 ? $sortHead.addClass('sorted-asc') : $sortHead.addClass('sorted-desc');
//
//                 //identify the column to be sorted by
//                 $('td').removeClass('sorted')
//                     .filter(':nth-child(' + (column + 1) + ')')
//                     .addClass('sorted');
//
//                 $('.visible td').removeClass('odd');
//                 zebraRows('.visible:even td', 'odd');
//             });
//     });
// });
//
//
// //used to apply alternating row styles
// function zebraRows(selector, className)
// {
//     $(selector).removeClass(className)
//         .addClass(className);
// }
//
// //filter results based on query
// function filter(selector, query) {
//     query	=	$.trim(query); //trim white space
//     query = query.replace(/ /gi, '|'); //add OR for regex
//
//     $(selector).each(function() {
//         ($(this).text().search(new RegExp(query, "i")) < 0) ? $(this).hide().removeClass('visible') : $(this).show().addClass('visible');
//     });
// }
//
// $(".ErrorRow").dblclick(function(e){
//     //alert($(this).find("td").eq(1).html());
//     alert($(this).find("td:last").html());
// })
const download = (type,id) => {
    const el = document.getElementById(id);
    const file = XLSX.utils.table_to_book(el);
    // Configuring width of the columns:
    file.Sheets.Sheet1["!cols"] = [{ wpx: 210 }, { wpx: 120 }, { wpx: 80 }];
    return XLSX.writeFile(file, id+"." + type);
};
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",0.2);
}

