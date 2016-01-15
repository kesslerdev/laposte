<?xml version="1.0" encoding="UTF-8"?>
<DonneesDepot xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <Identification VerParam="{{$wtVersion}}" ModeAff="{{$afMode}}" NoDepot="{{$deposeNumber}}" DateDepot="{{date("d/m/Y")}}" CoclicoFacturation="{{$coclicoFacturation}}" CoclicoContractant="{{$coclicoContactant}}" CoclicoDeposant="{{$coclicoDeposant}}" LibelleDepot="{{$depositLabel}}" CodeSiteDepot="{{$depositSite}}" CodePdtCom="{{$prodCom}}" AutoAff="{{$noMachine}}" NoContratPdt="{{$noCtrProduct}}" StatutDepot="0">
        <Emetteur>
            <CoclicoEmetteur>{{$coclicoEmeteur}}</CoclicoEmetteur>
        </Emetteur>
    </Identification>
    <DonneesServices>
        <DonneesPlisIDT CodeProd="{{$codeProd}}" NumCompteSuivi="{{$suivAccount}}">
            <Expediteur IdExpe="{{$socName}}" Adr4Expe="{{$socAdd}}" CPExpe="{{$socCP}}" ComExpe="{{$socCity}}" TelExpe="{{$socTel}}" CourrielExpe="{{$socmMail}}">
                @foreach($envelops as $env)
                    <Pli NoPli="{{substr($env->getTrackingNumber(),2)}}" IdDestT="{{$env->getName()}}" Adr4DestT="{{$env->getAddress()}}" CPDestT="{{$env->getPostalCode()}}" ComDestT="{{$env->getCity()}" TelDestT="{{$env->getPhone()}}" CourrielDestT="{{$env->getMail()}}"/>
                @endforeach
            </Expediteur>
        </DonneesPlisIDT>
    </DonneesServices>
</DonneesDepot>
