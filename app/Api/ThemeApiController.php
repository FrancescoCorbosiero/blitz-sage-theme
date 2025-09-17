<?php
class ThemeApiController {
    public function getBlocks() {
        return response()->json([
            'blocks' => $this->getAvailableBlocks(),
            'schemas' => $this->getBlockSchemas()
        ]);
    }
    
    public function renderBlock(Request $request) {
        $block = BlockFactory::create(
            $request->input('type'),
            $request->input('data', [])
        );
        
        return response()->json([
            'html' => $block->render()
        ]);
    }
}