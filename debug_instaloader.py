import instaloader
import json
import sys
import traceback

print("Initializing Instaloader...")
L = instaloader.Instaloader(
    download_pictures=False,
    download_videos=False, 
    download_video_thumbnails=False,
    compress_json=False, 
    save_metadata=False,
    user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
)

shortcode = 'DTsoan8jc_Z'
print(f"Fetching post {shortcode}...")

try:
    post = instaloader.Post.from_shortcode(L.context, shortcode)
    print("Post fetched successfully")
    
    data = {
        'caption': post.caption,
        'url': post.url,
        'typename': post.typename
    }
    print(json.dumps(data, indent=2))
    
except Exception as e:
    print(f"Error: {e}")
    traceback.print_exc()
