<ul>
	@foreach($childs as $child)

	<li>
		<a onclick="object.setUrl('category/edit/{{$child->id}}').setMethod('get').load();">{{ $child->name }}</a>
		@if(count($child->childs))
		@include('categories/manageChild',['childs' => $child->childs])
		@endif
	</li>
	@endforeach
</ul>
