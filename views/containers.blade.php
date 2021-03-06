<style>
    .container{
        width:105mm;
        height: 35mm;
        margin-bottom: 5mm;

        position: relative;

        border: 1px solid black;


        font-weight: bold;


    }

    .title{
        width:48mm;
        height: 12mm;

        position: absolute;
        top:5mm;
        left:7mm;

    //border: 1px solid black;

        text-align: center;
        font-size: 35px;
    }
    .apch{
        width:58mm;
        height: 5mm;

        position: absolute;

        top:28mm;
        left:2mm;

    //border: 1px solid black;

        text-align: center;

        padding-top: 5px;

        font-size: 9px;



    }
    .product{
        width:32mm;
        height: 25mm;

        position: absolute;
        top:5mm;
        left:65mm;

    //border: 1px solid black;


        text-align: center;
        line-height: 13mm;


        font-size: 30px;
    }
    .product .gamme{
        font-size: 35px;

    }
    span{
        text-transform: uppercase;
    }
</style>


<page backtop="6mm">
    @foreach($containers as $container)
        <div class="container">
            <div class="title">
                {{$container->title}}
            </div>
            <div class="apch">
                APCH-S3C de <span>{{$container->apch}}</span>
            </div>
            <div class="product">
                <span class="gamme">{{$container->product}}</span>
            </div>
        </div>
    @endforeach
</page>