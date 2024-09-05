<?php

namespace App\Jobs;

use App\Models\Podcast;
use App\PodcastStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    public function __construct(Podcast $podcast)
    {
        $this->podcast = $podcast;
    }

    public function handle()
    {
        $statuses = [
            PodcastStatus::GENERATING,
            PodcastStatus::EDITING,
            PodcastStatus::PROCESSING,
            PodcastStatus::PUBLISHING,
            PodcastStatus::FINALIZING,
            PodcastStatus::PUBLISHED,
        ];

        $totalDuration = 45; // 45 seconds
        $intervalDuration = $totalDuration / (count($statuses) - 1);

        foreach ($statuses as $index => $status) {
            $this->podcast->update(['status' => $status->value]);

            if ($index < count($statuses) - 1) {
                sleep($intervalDuration);
            }
        }
    }
}
