<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  @include('vendor.cssjs')
  <style type="text/css">
    .styled-select {
      background: url(//ap-statics.loas.jp/mm2/public/select.png) no-repeat 96% 0;
      height: 29px;
      overflow: hidden;
      width: 300px;
      margin-left: 25px;
      margin-top: 20px;
    }
    .semi-square {
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
    }
    .blue {
      background-color: #eac9ff;
    }
    .blue select {
      color: #000;
    }
    .styled-select select {
      background: transparent;
      border: none;
      font-size: 14px;
      height: 29px;
      padding: 5px;
      /* If you add too much padding here, the options won't show in IE */
      width: 328px;
    }
  </style>
</head>
<body>

<div class="wrapper">
  @include('vendor.topMenu')

  <div class="contents">
    @include('vendor.left')
    <div class="contents_right">
      @include('vendor.rightSlider')
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/pointMall/intro.html#rightContent">ポイントモール</a></span> ＞ <span class="sub_page_nav_current">ACポイントとは</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_point_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item point_tab_item1">ACポイントとは</div>
            <div class="coin_tab_item point_tab_item2 on">ポイントモール</div>
            <div class="coin_tab_item point_tab_item3">ACポイント履歴</div>
          </div>
          <div class="styled-select blue semi-square">
            <select id="serverId" name="serverId">
              <option value ="0">アカウントを選択してください</option>
              @foreach ($userGameInfo as $userinfo)
              <option value ="{{ $userinfo['serverId'] }}">{{ $userinfo['serverName'] }} - {{ $userinfo['roleName'] }} - Lv.{{ $userinfo['level'] }}</option>
              @endforeach
            </select>
          </div>
          <table class="point_item_list">
            <tr>
              <th width="28%">商品名</th>
              <th width="43%">説明</th>
              <th width="7%">数</th>
              <th width="22%">価格</th>
            </tr>
            @foreach ($items as $itemId => $itemInfo)
            <tr>
              <td><img src="{{ $itemInfo['picPath'] }}">{{ $itemInfo['name'] }}</td>
              <td>{{ $itemInfo['desc'] }}</td>
              <td><select id="count_{{ $itemId }}" name="count_{{ $itemId }}"><option value ="1">1</option><option value ="2">2</option><option value ="3">3</option><option value ="4">4</option><option value ="5">5</option><option value ="6">6</option><option value ="7">7</option><option value ="8">8</option><option value ="9">9</option><option value ="10">10</option><option value ="11">11</option><option value ="12">12</option><option value ="13">13</option><option value ="14">14</option><option value ="15">15</option><option value ="16">16</option><option value ="17">17</option><option value ="18">18</option><option value ="19">19</option><option value ="20">20</option><option value ="21">21</option><option value ="22">22</option><option value ="23">23</option><option value ="24">24</option><option value ="25">25</option><option value ="26">26</option><option value ="27">27</option><option value ="28">28</option><option value ="29">29</option><option value ="30">30</option><option value ="31">31</option><option value ="32">32</option><option value ="33">33</option><option value ="34">34</option><option value ="35">35</option><option value ="36">36</option><option value ="37">37</option><option value ="38">38</option><option value ="39">39</option><option value ="40">40</option><option value ="41">41</option><option value ="42">42</option><option value ="43">43</option><option value ="44">44</option><option value ="45">45</option><option value ="46">46</option><option value ="47">47</option><option value ="48">48</option><option value ="49">49</option><option value ="50">50</option><option value ="51">51</option><option value ="52">52</option><option value ="53">53</option><option value ="54">54</option><option value ="55">55</option><option value ="56">56</option><option value ="57">57</option><option value ="58">58</option><option value ="59">59</option><option value ="60">60</option><option value ="61">61</option><option value ="62">62</option><option value ="63">63</option><option value ="64">64</option><option value ="65">65</option><option value ="66">66</option><option value ="67">67</option><option value ="68">68</option><option value ="69">69</option><option value ="70">70</option><option value ="71">71</option><option value ="72">72</option><option value ="73">73</option><option value ="74">74</option><option value ="75">75</option><option value ="76">76</option><option value ="77">77</option><option value ="78">78</option><option value ="79">79</option><option value ="80">80</option><option value ="81">81</option><option value ="82">82</option><option value ="83">83</option><option value ="84">84</option><option value ="85">85</option><option value ="86">86</option><option value ="87">87</option><option value ="88">88</option><option value ="89">89</option><option value ="90">90</option><option value ="91">91</option><option value ="92">92</option><option value ="93">93</option><option value ="94">94</option><option value ="95">95</option><option value ="96">96</option><option value ="97">97</option><option value ="98">98</option><option value ="99">99</option></select></td>
              @if ($itemInfo['isSalesTime'] === true)
              <td align="center"><STRIKE>{{ $itemInfo['point'] }}</STRIKE> <span style="color: #ff0000;">{{ $itemInfo['salesPoint'] }}</span> ACポイント<br /><div class="point_buy_button" onclick="javascript:pointConfirm('{{ $itemId }}');"></div></td>
              @else
              <td align="center">{{ $itemInfo['point'] }} ACポイント<br /><div class="point_buy_button" onclick="javascript:pointConfirm('{{ $itemId }}');"></div></td>
              @endif
            </tr>
            @endforeach
          </table>
        </div>
        <div class="sub_page_right_bottom"></div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>
<script type="text/javascript">
function pointConfirm(_itemId) {
	layer.closeAll();
  _serverId = $('#serverId').val();
  _itemCount = ($('#count_' + _itemId).val() >= 1) ? $('#count_' + _itemId).val() : 1;

  if(_serverId == '0') {
    layer.alert('先にアカウントを選択してください。', {
      icon: 2,
      title: 'エラー！',
      btn: ['OK']
    });

    return;
  }

  layer.open({
    type: 2,
    title: false,
    closeBtn: false,
    shadeClose: true,
    shade: 0.8,
    area: ['551px', '301px'],
    content: '{{ config('app.httpsBaseUrl')}}/pointMall/itemInfo/' + _itemId + '/' + _serverId + '/' + _itemCount
  });
}
</script>
</body>
</html>