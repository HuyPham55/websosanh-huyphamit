<table class="table table-bordered table-hover">
    <tbody>
    <tr>
        <th scope="row">{{ __('label.subject') }}</th>
        <td>{{ $contact->subject }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('label.name') }}</th>
        <td>{{ $contact->name }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('label.phone') }}</th>
        <td>{{ $contact->phone }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('label.email') }}</th>
        <td>{{ $contact->email }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('label.address') }}</th>
        <td>{{ $contact->address }}</td>
    </tr>
    <tr>
        <th scope="row">{{ __('backend.content') }}</th>
        <td>{{ $contact->message }}</td>
    </tr>
    </tbody>
</table>
