var pointChargeInfo = new Array();
var purchaseInfo = new Array();
var payWayInfo = new Array();

@foreach ($chargeInfo['chargeInfo'] as $itemCode => $info)
pointChargeInfo['{{ $itemCode }}'] = {'name' : '{{ $info['name'] }}', 'pay' : {{ $info['pay'] }}, 'point' : {{ $info['point'] }}@if(isset($info['pointOriginal'])), 'pointOriginal' : {{ $info['pointOriginal'] }}@endif};
@endforeach

@foreach ($purchaseInfo as $purchaseInfoCode => $infoP)
purchaseInfo['{{ $purchaseInfoCode }}'] = {'name' : '{{ $infoP['name'] }}', 'price' : {{ $infoP['price'] }}, 'diamond' : {{ $infoP['diamond'] }}};
@endforeach

@foreach ($payWay as $payWayCode => $infoW)
payWayInfo['{{ $payWayCode }}'] = {'name' : '{{ $infoW['name'] }}'};
@endforeach