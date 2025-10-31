<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SparePartRequest;

class NewSparePartRequestNotification extends Notification
{
    use Queueable;

    protected $sparePartRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(SparePartRequest $sparePartRequest)
    {
        $this->sparePartRequest = $sparePartRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('spare-part-requests.index');

        return (new MailMessage)
                    ->subject('Nueva Solicitud de Repuesto')
                    ->greeting('¡Hola!')
                    ->line('Se ha generado una nueva solicitud de repuesto.')
                    ->line('**Técnico:** ' . $this->sparePartRequest->user->name)
                    ->line('**Equipo:** ' . $this->sparePartRequest->asset->nombre_equipo)
                    ->line('**Repuesto:** ' . $this->sparePartRequest->part_name)
                    ->line('**Cantidad:** ' . $this->sparePartRequest->quantity)
                    ->action('Ver Solicitudes de Repuestos', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}