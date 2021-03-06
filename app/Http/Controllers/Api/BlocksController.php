<?php

namespace App\Http\Controllers\Api;

use Cache;
use Droplister\XcpCore\App\Block;
use App\Http\Resources\BlockResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Block Index
        $block_index = Cache::get('block_index') ? Cache::get('block_index') : Block::latest('block_index')->first()->block_index;

        // Cache Slug
        $cache_slug = 'api_blocks_index_' . $block_index . '_' . str_slug(serialize($request->all()));

        // Get Blocks
        return Cache::remember($cache_slug, 1440, function () use ($request) {
            // The Blocks
            $blocks = Block::withCount('cancels', 'expirations', 'orders', 'orderMatches')
                ->orderBy('block_index', 'desc')
                ->paginate(30);

            return [
                'blocks' => BlockResource::collection($blocks),
                'last_page' => ceil($blocks->total() / 30),
                'current_page' => (int) $request->input('page', 1),
            ];
        });
    }
}