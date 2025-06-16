@if($popup !== false)
<script type="text/javascript">
  @if(($popup == "showServers") && (Session::get('loggedIn') === true))
    @if(Session::get('userInfo.isAgreedPrivacy') === 1) {
      showServers()
    } @else {
      showPrivacy();
    }
    @endif
  @endif

  @if(($popup == "showLogin") && (Session::get('loggedIn') !== true))
  showLogin();
  @endif
</script>
@endif