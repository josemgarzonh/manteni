<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FailureAttention; // Crearemos este modelo más adelante

class FailureAttendedNotification extends Notification
{
    use Queueable;

    protected $attention;

    /**
     * Create a new notification instance.
     */
    public function __construct(FailureAttention $attention)
    {
        $this->attention = $attention;
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
        return (new MailMessage)
                    ->subject('Actualización de tu Reporte de Falla: #' . $this->attention->maintenance_request_id)
                    ->greeting('¡Hola, ' . ($this->attention->maintenanceRequest->user->name ?? $this->attention->maintenanceRequest->solicitante_nombre) . '!')
                    ->line('Tu reporte de falla ha sido atendido. A continuación, los detalles:')
                    ->line('**Técnico Asignado:** ' . $this->attention->technician->name)
                    ->line('**Estado de la Falla:** ' . ucfirst($this->attention->estado_falla))
                    ->line('**Detalles Técnicos:** ' . $this->attention->detalles_tecnicos)
                    ->line('Gracias por tu paciencia.');
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