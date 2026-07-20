<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url>
        <loc>{{ route('home') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('projects.public.index') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('certificates.public.index') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('blog.index') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Dynamic Projects -->
    @foreach($projects as $project)
        <url>
            <loc>{{ route('projects.public.show', $project->slug) }}</loc>
            <lastmod>{{ $project->updated_at ? $project->updated_at->toAtomString() : ($project->created_at ? $project->created_at->toAtomString() : now()->toAtomString()) }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Dynamic Blogs -->
    @foreach($blogs as $blog)
        <url>
            <loc>{{ route('blog.show', $blog->slug) }}</loc>
            <lastmod>{{ $blog->updated_at ? $blog->updated_at->toAtomString() : ($blog->created_at ? $blog->created_at->toAtomString() : now()->toAtomString()) }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
