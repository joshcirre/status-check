<?php

namespace App;

enum PodcastStatus: string
{
    case GENERATING = 'generating';
    case EDITING = 'editing';
    case PROCESSING = 'processing';
    case PUBLISHING = 'publishing';
    case FINALIZING = 'finalizing';
    case PUBLISHED = 'published';
}
