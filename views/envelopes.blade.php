<style>
    .avoid{
        page-break-inside:avoid;
    }
    .eticket{
        height: 56mm;
        width : 104mm;
        float: left;
    /*border: 1px solid red;*/
    }
    .idt{
        width: 90mm;

        height: 16mm;

        padding-left: 5mm;
        padding-top: 2mm;

        position: relative;

    /*border: 1px solid black;*/
    }
    .code{
        height: 3mm;

    /*border: 1px solid black;*/
        margin-bottom: 2mm;

    }
    .barcode{
        height: 7mm;

    /*border: 1px solid black;*/
    }
    .img-barcode{
        margin-left: -3mm;
        height: 7mm;
        width: 70mm;
    }
    .picture{
        width: 12mm;
        height: 12mm;
        position: absolute;

        right: 12mm;
        top:2mm;
    }
    .adress{
        padding-left: 5mm;
        padding-top: 2mm;
        padding-bottom: 2mm;
    /*border: 1px solid black;*/
        text-transform: uppercase;
        line-height: 5mm;

        border-bottom: 1px solid darkgray;
    }
    .info{
        padding-left: 5mm;
        padding-top: 2mm;
    /*border: 1px solid black;*/
        font-size: 10px;

    }
</style>


@foreach(array_chunk($envelopes, 10) as $page)

    <page backtop="6mm" >
        <table>


            <?php $altern = false;?>
            <tr>
                <td>
                    @foreach($page as $tc)
                        @if($altern)</td><td> <?php $altern = false; ?> @else </td></tr><tr><td><?php $altern = true; ?> @endif
                    <div class="eticket">
                        <div class="idt">
                            <div class="code">
                                @if($tc->getTrackingNumber())
                                    {{substr($tc->getTrackingNumber(),0,2)}} {{substr($tc->getTrackingNumber(),2,strlen($tc->getTrackingNumber())-3)}} {{substr($tc->getTrackingNumber(),strlen($tc->getTrackingNumber())-1,1)}}
                                @endif
                            </div>

                            <div class="barcode">
                                @if($tc->getTrackingNumber())

                                    <barcode type="C128A" value="{{$tc->getTrackingNumber()}}" label="none" style="margin-left:0mm;height: 7mm;width: 65mm;"></barcode>
                                @else


                                @endif
                            </div>

                            <div class="picture">
                                <img src="http://manager.accessoirestelephones.com/lcs.jpg" style="height: 12mm;width:auto;"/>
                            </div>
                        </div>
                        <div class="adress">
                            {{nl2br($tc->getFullAddress())}}
                        </div>
                        <div class="info">
                            {{$info($tc)}}
                        </div>
                    </div>
                    @endforeach
                </td>
            </tr>
        </table>
    </page>
@endforeach