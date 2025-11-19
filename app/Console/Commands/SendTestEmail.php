<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test 
                            {email? : Email address to send test to}
                            {--mailer= : Specific mailer to use (gmail, mailgun, sendgrid)}
                            {--details : Show detailed output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test email to verify email configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $mailer = $this->option('mailer');
        $showDetails = $this->option('details');

        // If no email provided, ask for it
        if (! $email) {
            $email = $this->ask('Enter email address to send test email to');
        }

        // Validate email
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('❌ Invalid email address!');

            return 1;
        }

        $this->info('📧 Sending test email...');
        $this->newLine();

        // Show configuration
        if ($showDetails) {
            $this->info('Configuration:');
            $this->line('  MAIL_MAILER: ' . config('mail.default'));
            $this->line('  MAIL_HOST: ' . config('mail.mailers.smtp.host'));
            $this->line('  MAIL_PORT: ' . config('mail.mailers.smtp.port'));
            $this->line('  MAIL_FROM: ' . config('mail.from.address'));
            $this->newLine();
        }

        try {
            $startTime = microtime(true);

            // Build email content
            $subject = 'Test Email - Sistem Pertanian Toba';
            $message = $this->buildEmailMessage();

            // Send email
            if ($mailer) {
                Mail::mailer($mailer)->send([], [], function ($mail) use ($email, $subject, $message) {
                    $mail->to($email)
                        ->subject($subject)
                        ->html($message);
                });
                $this->info("✅ Email sent successfully via {$mailer}!");
            } else {
                Mail::send([], [], function ($mail) use ($email, $subject, $message) {
                    $mail->to($email)
                        ->subject($subject)
                        ->html($message);
                });
                $this->info('✅ Email sent successfully!');
            }

            $duration = round((microtime(true) - $startTime) * 1000, 2);

            $this->newLine();
            $this->info('📬 Email Details:');
            $this->line("  To: {$email}");
            $this->line("  Subject: {$subject}");
            $this->line('  Mailer: ' . ($mailer ?: config('mail.default')));
            $this->line("  Duration: {$duration}ms");
            $this->newLine();

            $this->info('Check your inbox (and spam folder)!');

            // Show log location if using log driver
            if (config('mail.default') === 'log') {
                $this->warn('⚠️  Using LOG driver - email saved to: storage/logs/laravel.log');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Email failed to send!');
            $this->newLine();
            $this->error('Error: ' . $e->getMessage());

            if ($showDetails) {
                $this->newLine();
                $this->error('Stack trace:');
                $this->line($e->getTraceAsString());
            }

            $this->newLine();
            $this->warn('💡 Troubleshooting:');
            $this->line('  1. Check .env email configuration');
            $this->line('  2. Verify MAIL_USERNAME and MAIL_PASSWORD');
            $this->line('  3. Check firewall allows SMTP port');
            $this->line('  4. Run: php artisan config:clear');
            $this->line('  5. Check storage/logs/laravel.log for details');

            return 1;
        }
    }

    /**
     * Build HTML email message.
     */
    protected function buildEmailMessage(): string
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $config = config('mail.default');

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { background: #f9f9f9; padding: 30px; border: 1px solid #ddd; }
                .footer { background: #333; color: white; padding: 15px; text-align: center; font-size: 12px; border-radius: 0 0 5px 5px; }
                .info-box { background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 15px; margin: 15px 0; }
                .success { color: #4CAF50; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>✅ Test Email Successful!</h1>
                </div>
                <div class='content'>
                    <h2>Sistem Pertanian Toba</h2>
                    <p>Congratulations! Your email configuration is working correctly.</p>
                    
                    <div class='info-box'>
                        <h3>📧 Email Information</h3>
                        <p><strong>Sent at:</strong> {$timestamp}</p>
                        <p><strong>Mailer:</strong> {$config}</p>
                        <p><strong>From:</strong> " . config('mail.from.address') . '</p>
                        <p><strong>Application:</strong> ' . config('app.name') . "</p>
                    </div>
                    
                    <h3>✅ What This Means</h3>
                    <ul>
                        <li>SMTP configuration is correct</li>
                        <li>Email credentials are valid</li>
                        <li>Firewall allows SMTP connection</li>
                        <li>Email delivery is working</li>
                    </ul>
                    
                    <h3>🚀 Next Steps</h3>
                    <ol>
                        <li>Test email verification flow</li>
                        <li>Configure queue for bulk emails</li>
                        <li>Set up email templates</li>
                        <li>Monitor deliverability</li>
                    </ol>
                    
                    <p class='success'>Your email system is ready for production! 🎉</p>
                </div>
                <div class='footer'>
                    <p>© 2025 Sistem Pertanian Toba - Automated Test Email</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
