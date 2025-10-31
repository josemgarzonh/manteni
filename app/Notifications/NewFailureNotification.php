<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\MaintenanceRequest;

class NewFailureNotification extends Notification
{
    use Queueable;

    protected $maintenanceRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(MaintenanceRequest $maintenanceRequest)
    {
        $this->maintenanceRequest = $maintenanceRequest;
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
        $url = route('failures.attend', $this->maintenanceRequest->id);

        return (new MailMessage)
                    ->subject('Nuevo Reporte de Falla: #' . $this->maintenanceRequest->id)
                    ->greeting('¡Hola!')
                    ->line('Se ha generado un nuevo reporte de falla que requiere atención.')
                    ->line('**Equipo:** ' . ($this->maintenanceRequest->asset->nombre_equipo ?? 'No especificado'))
                    ->line('**Ubicación:** ' . $this->maintenanceRequest->ubicacion_texto)
                    ->line('**Descripción:** ' . $this->maintenanceRequest->descripcion)
                    ->action('Atender Falla', $url)
                    ->line('Gracias por tu pronta atención.');
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