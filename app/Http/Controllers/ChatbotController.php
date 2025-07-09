<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'message' => 'required|string|max:500',
            ]);

            // Retrieve the user's message
            $message = $validated['message'];
            Log::info('Chat request received', ['message' => $message]);

            // Define the system context
            $context = 'You are an experienced HR Manager Assistant, helping with various HR-related queries and tasks.
            
Your responsibilities include:
- Providing information about company policies, benefits, and procedures
- Helping with recruitment processes, interview scheduling, and candidate evaluation
- Assisting with employee onboarding, training, and development
- Addressing workplace concerns, conflicts, and employee relations
- Supporting with performance management, reviews, and feedback
- Providing guidance on compliance with labor laws and regulations
- Assisting with leave management, attendance tracking, and time-off requests
- Offering resources for employee wellness, engagement, and retention
- Helping with payroll inquiries, compensation, and benefits administration

Keep your responses professional, empathetic, and focused on HR best practices. Always prioritize confidentiality, ethics, and compliance with relevant laws. If asked about specific legal advice, recommend consulting with a qualified legal professional.';

            // Prepare the data to be sent to OpenRouter.ai
            $apiKey = env('OPENROUTER_API_KEY', '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');
            $siteUrl = url('/');
            $siteName = 'HR Management Portal';
            $model = env('OPENROUTER_MODEL', 'mistralai/devstral-small:free');
            
            // Prepare messages array
            $messages = [
                ['role' => 'system', 'content' => $context],
                ['role' => 'user', 'content' => $message],
            ];
            
            // IMPORTANT: Disable SSL verification to fix the SSL certificate error
            $response = Http::withOptions([
                'verify' => false, // This disables SSL certificate verification
            ])->withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => $siteUrl,
                'X-Title' => $siteName,
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $model,
                'messages' => $messages,
            ]);

            // Handle the response from OpenRouter.ai
            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['choices'][0]['message']['content'])) {
                    $reply = $responseData['choices'][0]['message']['content'];
                    return response()->json(['response' => $reply]);
                } else {
                    return response()->json(['response' => 'I received an unexpected response format. Please try again.']);
                }
            } else {
                // Return a user-friendly error message
                return response()->json(
                    ['response' => 'Sorry, I\'m having trouble connecting right now. Please try again later.'],
                    200
                );
            }
        } catch (\Exception $e) {
            Log::error('Exception in ChatbotController', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(
                ['response' => 'I encountered an unexpected error. Please try again later.'],
                200
            );
        }
    }
    
    // Keep your test methods for debugging if needed
    public function testConnection(Request $request)
    {
        $apiKey = env('OPENROUTER_API_KEY', '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');
        $model = 'mistralai/devstral-small:free';
        
        // Check if API key is correctly formatted
        if (!preg_match('/^sk-or-v1-[a-zA-Z0-9]+$/', $apiKey)) {
            return response()->json(['error' => 'API key format appears incorrect']);
        }
        
        // Test connection with a simple request
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
            'HTTP-Referer' => url('/'),
        ])->get('https://openrouter.ai/api/v1/auth/key');
        
        // Return the full response for debugging
        return response()->json([
            'status' => $response->status(),
            'body' => $response->json(),
            'api_key_used' => substr($apiKey, 0, 10) . '...',
            'model_used' => $model
        ]);
    }
    
    public function simpleTest(Request $request)
    {
        try {
            $apiKey = env('OPENROUTER_API_KEY', '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');
            $siteUrl = url('/');
            $siteName = 'Course Learning Platform';
            
            // Use the exact same model that works in your Python code
            $model = 'mistralai/devstral-small:free';
            
            // Send a simple request with the exact same format as your Python code
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => $siteUrl,
                'X-Title' => $siteName,
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => 'Say hello'],
                ],
            ]);
            
            return response()->json([
                'status' => $response->status(),
                'body' => $response->json(),
                'raw' => $response->body(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}