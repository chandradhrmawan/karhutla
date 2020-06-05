<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

<script type="text/javascript">
function modal_form()
{
//open modal
var url = location.origin+'/get_form';
$.ajax(
 {
    type: "GET",
    url: url,
    success: function(ress) 
    { 
      $('.modal-content').html(ress);
    },
    error: function(error)
    {
      alert(error);
    }
 });
}
</script>