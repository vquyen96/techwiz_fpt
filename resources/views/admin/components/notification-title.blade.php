@switch($noti->type)
    @case (App\Enums\NotificationAdmin\Type::TICKET)
    {{ __('locale/components/notification-title.new_ticket') }}
    @break
    @case (App\Enums\NotificationAdmin\Type::TICKET_COMMENT)
    {{ __('locale/components/notification-title.new_ticket_comment') }}
    @break
@endswitch