<?php  
$isr_contact_name = 'Planview';
$isr_contact_location = 'North America';
$isr_contact_phone = '(800) 856-8600';
$isr_contact_mobile = 'Web: <a href="http://www.planview.com/company/contact/" title="Contact Planview" target="_blank">Contact Planview</a><br />';
$isr_contact_email = '<a href="mailto:market@planview.com" class="email-link" title="Email Planview">market@planview.com</a>';
?>

@if (Auth::user()->isr_contact_id)
    @if ($associatedIsrInfo = Isr::associatedIsrInfo(Auth::user()->isr_contact_id))
        <?php
        $isr_contact_name = $associatedIsrInfo->isr_first_name . ' ' . $associatedIsrInfo->isr_last_name;
        $isr_contact_location = $associatedIsrInfo->isr_location;
        $isr_contact_phone = $associatedIsrInfo->isr_phone;

        if ($associatedIsrInfo->isr_mobile_phone) {
            $isr_contact_mobile = 'Mobil: '.$associatedIsrInfo->isr_mobile_phone.'<br />';
        } else {
            $isr_contact_mobile = '';
        }

        $associatedIsrEmail = Isr::associatedIsrEmail(Auth::user()->isr_contact_id);

        $isr_contact_email = '<a href="mailto:'.$associatedIsrEmail.'" class="email-link" title="Email '.$associatedIsrInfo->isr_first_name . ' ' . $associatedIsrInfo->isr_last_name.'">'.$associatedIsrEmail.'</a>';
        ?>
    @endif
@elseif ($associatedIsrInfo = Isr::associatedIsrInfo(Auth::id()))
    <?php
    $isr_contact_name = $associatedIsrInfo->isr_first_name . ' ' . $associatedIsrInfo->isr_last_name;
    $isr_contact_location = $associatedIsrInfo->isr_location;
    $isr_contact_phone = $associatedIsrInfo->isr_phone;

    if ($associatedIsrInfo->isr_mobile_phone) {
        $isr_contact_mobile = 'Mobil: '.$associatedIsrInfo->isr_mobile_phone.'<br />';
    } else {
        $isr_contact_mobile = '';
    }

    $associatedIsrEmail = Auth::user()->email;

    $isr_contact_email = '<a href="mailto:'.$associatedIsrEmail.'" class="email-link" title="Email '.$associatedIsrInfo->isr_first_name . ' ' . $associatedIsrInfo->isr_last_name.'">'.$associatedIsrEmail.'</a>';
    ?>
@endif

<div class="module-contact-info">
    <h2 id="header-contact">Contact</h2>
    <p><strong>{{ $isr_contact_name }}</strong><br />
    Location: {{ $isr_contact_location }}<br />
    Tel: {{ $isr_contact_phone }}<br />
    {{ $isr_contact_mobile }}
    Email: {{ $isr_contact_email }}</p>
</div>
