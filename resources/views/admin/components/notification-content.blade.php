@switch($noti->type)
    @case (App\Enums\NotificationAdmin\Type::TICKET)
    {{ $noti->target->name }} {{ __('locale/components/notification-content.has_send_ticket') }}
    @break
    @case (App\Enums\NotificationAdmin\Type::TICKET_COMMENT)
    {{ $noti->target->name }} {{ __('locale/components/notification-content.has_reply_ticket') }}
    @break
@endswitch