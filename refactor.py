import os
import re

directory = 'resources/views'

def process_file(filepath):
    if 'layouts/' in filepath:
        return
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
        
    if "@extends('layouts.app')" not in content:
        return
        
    # Extract title
    title_match = re.search(r"@section\('title',\s*'([^']+)'\)", content)
    title = title_match.group(1) if title_match else ''
    
    # Remove extends and title
    content = re.sub(r"@extends\('layouts\.app'\)\n*", '', content)
    content = re.sub(r"@section\('title',\s*'[^']+'\)\n*", '', content)
    
    # Replace @section('content') with <x-app-layout>
    app_layout_open = f'<x-app-layout title="{title}">' if title else '<x-app-layout>'
    content = re.sub(r"@section\('content'\)\n*", f"{app_layout_open}\n", content)
    
    # We need to replace the @endsection that corresponds to @section('content')
    # It's usually the first @endsection after @section('content')
    # but there might be nested sections? Probably not in these views.
    # Actually, blade @push/@endpush are used, but they are not @section.
    # So replacing the last @endsection might work, or we can just replace all @endsection that close 'content'.
    # Actually, we can just replace the *first* @endsection since @section('content') is the only section.
    content = re.sub(r"@endsection", "</x-app-layout>", content, count=1)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Refactored {filepath}")

for root, dirs, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            process_file(os.path.join(root, file))
