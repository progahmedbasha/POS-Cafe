<! -- sweet alert toaster js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js">
    </script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- RTL Css -->
    <link rel="stylesheet" href="{{url('assets/admin/css/rtl.min.css')}}" />
    @if(Session::has('success'))
    <script>
        toastr.success(" {{ Session::get( 'success' ) }} ");
    </script>
    @elseif (Session::has('error'))
    <script>
        toastr.error(" {{ Session::get('error') }} ");
    </script>
    @elseif(Session::has('info'))
    <script>
        toastr.info(" {{ Session::get('info') }} ");
    </script>
    @elseif(Session::has('warning'))
    <script>
        toastr.warning(" {{ Session::get('warning') }} ");
    </script>
    @endif