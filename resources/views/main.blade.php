<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Timetable</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.12/dist/css/uikit.min.css" />

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
        
        <!-- UIkit JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.12/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.12/dist/js/uikit-icons.min.js"></script>
        
        <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        
        <style>
            html {
                height: 100%;
            }
            body {
                min-height: 100%;
                background-color:#f1f4f6;
            }
            .so-box {
                background-color:#fff;
            }
            label {
                line-height: 30px;
            }
            .app-label {
                visibility: hidden;
            }
            #table td{
                text-align: center;
            }
        </style>
    </head>
    <body class="">
        <div class="uk-container uk-flex uk-flex-center uk-flex-middle uk-padding">
            <div class="uk-width-1-1 so-box uk-padding">
                <div class="uk-margin-medium-bottom" uk-grid>
                    <h1 class="uk-h1 uk-width-expand">Terminarz połączeń zdalnych</h1>
                    <button class="uk-button uk-width-1-4" type="button" uk-toggle="target: #form; animation: uk-animation-fade">Dodaj wideo</button>
                </div>
                @if (count($errors) > 0)
                    <div class="uk-alert-danger" uk-alert>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div id="modal" class="uk-open" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <h2 class="uk-modal-title">{{ session()->get('message') }}</h2>
                            <button class="uk-button uk-button-default uk-modal-close" type="button">Zamknij</button>
                        </div>
                    </div>
                @endif
                <div id="form" class="uk-margin-bottom" hidden>
                    <form action="{{ route('postTrial') }}" method="POST" class="uk-form">
                        @csrf
                        <div class="uk-child-width-1-3 uk-margin-medium-bottom" uk-grid>
                            <div>
                                <label for="trial_date">Data rozprawy</label>
                                <input required class="uk-input" type="date" placeholder="Data rozprawy" name="trial_date">
                            </div>
                            <div>
                                <label for="time">Godzina rozprawy</label>
                                <input required class="uk-input" type="time" placeholder="Godzina" name="time">
                            </div>
                            <div>
                                <label class="app-label" for="app">label</label>
                                <select class="uk-select" name="app" required>
                                    <option value="" hidden disabled selected>Aplikacja</option>
                                    <option value="Jitsi">Jitsi</option>
                                    <option value="Scopia">Scopia</option>
                                </select>
                            </div>
                            <div>
                                <select class="uk-select" name="location" required>
                                    <option value="" hidden disabled selected>Lokalizacja</option>
                                    <option value="3 maja">3 Maja</option>
                                    <option value="Nowe Ogrody">Nowe Ogrody</option>
                                </select>
                            </div>
                            <div>
                                <input required class="uk-input" type="text" placeholder="Sala" name="room">
                            </div>
                            <div>
                                <input required class="uk-input" type="text" placeholder="Sygantura" name="signature">
                            </div>
                            <div>
                                <input required class="uk-input" type="text" placeholder="Imie" name="first_name" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ]+">
                            </div>
                            <div>
                                <input required class="uk-input" type="text" placeholder="Nazwisko"  name="last_name" pattern="[A-Za-ząćęłńóśźżĄĘŁŃÓŚŹŻ]+">
                            </div>
                            <div>
                                <input required class="uk-input" type="tel" placeholder="Telefon" name="phone" pattern="[0-9]+">
                            </div>
                            <div>
                                <input required class="uk-input" type="text" placeholder="Wydział"  name="dept">
                            </div>
                            <div>
                                <input required class="uk-input" type="url" name="link" placeholder="Link">
                            </div>
                            <div>
                                <input class="uk-button" type="submit" value="Dodaj">
                            </div>
                        </div>
                    </form>
                </div>
                <table id="table">
                    <thead>
                        <tr>
                            <th>
                                Data rozprawy
                            </th>
                            <th>
                                Godzina rozprawy
                            </th>
                            <th>
                                Aplikacja
                            </th>
                            <th>
                                Lokalizacja (Budynek)
                            </th>
                            <th>
                                Sala
                            </th>
                            <th>
                                Sygnatura
                            </th>
                            <th>
                                Imię
                            </th>
                            <th>
                                Nazwisko
                            </th>
                            <th>
                                Telefon
                            </th>
                            <th>
                                Wydział
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($trials as $trial)
                        <tr>
                            <td>
                                {{$trial->trial_date}}
                            </td>
                            <td>
                                {{$trial->time}}
                            </td>
                            <td>
                                {{$trial->app}}
                            </td>
                            <td>
                                {{$trial->location}}
                            </td>
                            <td>
                                {{$trial->room}}
                            </td>
                            <td>
                                {{$trial->signature}}
                            </td>
                            <td>
                                {{$trial->first_name}}
                            </td>
                            <td>
                                {{$trial->last_name}}
                            </td>
                            <td>
                                {{$trial->phone}}
                            </td>
                            <td>
                                {{$trial->dept}}
                            </td>
                            <td>
                                <a class="" href="{{$trial->link}}">Link</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <script>
        $(document).ready( function () {
            if ($('#modal').length > 0) {
                UIkit.modal(modal).show();
            }
            $('#table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Polish.json'
                }
            });
        } );
    </script>
</html>
