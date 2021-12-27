@if($errors->any())
<script>
	swal({
		title: 'تأكد من ادخال البيانات صحيحة',
		html: '',
		type: 'error'
	})
</script>
@endif

@if (session('success'))
<script>
	swal({
		title: 'نجحت',
		html: 'تمت العملية بنجاح',
		type: 'success'
	})
</script>
@elseif (session('error'))
	<script>
        swal({
            title: 'Error',
            html: '{{ session('error') }}',
            type: 'error'
        })
	</script>
@endif

<script>
	$('button').parent('form:has(input[value="DELETE"]):not(".no-confirm")').click(function( e ) {
		e.preventDefault();
		var form = $(this).parents('form');
		swal({
			title: "هل انت متأكد انك تريد الحذف؟",
			text: "لن تتمكن من التراجع عن هذا الإجراء",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "نعم اريد الحذف!",
			cancelButtonText: "الغاء"
		}).then(result => {
			if (result.value) $(this).submit();
		});
	});
</script>
