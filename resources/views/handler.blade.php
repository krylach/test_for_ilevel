<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4">
                <p>Как и просили, указываю количество потраченного времени, работать мог по несколько часов в день, и то не всегда.</p>
                <p>Продукты - ~2.5 часа<br/>Категории - ~0.5 часа<br/>Фронт - ~3 часа</p>
                <div class="form-group">
                    <form action="/" method="get">
                        <label for="categories">Список категорий</label>
                        <select class="form-control" id="categories" name="select_category_id">
                            @if ($list_categories)
                                @foreach ($list_categories as $item)
                                    <option value="{{$item['id']}}" @if ($item['id'] == $select_category_id) selected @endif>{{$item['name']}}</option>
                                @endforeach       
                            @endif                 
                        </select>

                        <label for="category_name">Изменить выбранную катеорию</label>
                        <input type="text" class="form-control" id="category_name" name="new_name_category" placeholder="Новое имя для категории">
                        <button type="submit" class="btn btn-primary mt-2">Получить / Изменить</button>
                    </form>
                </div>
                <div class="form-group">
                    <label for="select">Список продуктов конкретной категории</label>
                    <select class="form-control" id="select">
                        @if ($list_products)
                            @foreach ($list_products as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach   
                        @endif                     
                    </select>
                </div>
                <div class="form-group">
                    <form action="/" method="get">
                        <label for="category">Создать категорю</label>
                        <input type="text" id="category" name="name_category" class="form-control" placeholder="Введите имя">
                        <button type="submit" class="btn btn-primary mt-2">Создать</button>
                    </form>
                </div>
                <p>Так же есть удаление, всё расположено в API. Работает через "Illuminate\Support\Facades\Http". Можете посмотреть в роутах, там всё расписано, из какого контроллера берётся и т.п.</p>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-md-4">
                <form action="/" method="get">
                    <div class="form-group">
                        <label for="select">Список всех продуктов</label>
                        <select class="form-control" id="select" name="selected_product_id">
                            @if ($all_list_products)
                                @foreach ($all_list_products as $item)
                                    <option 
                                        value="{{$item['id']}}"
                                        @if ($selected_product_id == $item['id']) 
                                            selected
                                        @endif
                                    >{{$item['name']}}</option>
                                @endforeach   
                            @endif                     
                        </select>
                        <button type="submit" class="btn btn-primary mt-2 mb-3">Получить</button>
                    </div>
                </form>
                <form action="/" method="get">
                    <div class="form-group">
                        <label for="category_name">Изменить выбранный продукт</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="category_name" 
                            name="new_name_product" 
                            @if (isset($selected_product['name'])) 
                                value="{{$selected_product['name']}}"  
                            @endif
                            placeholder="Новое имя для продукта"
                        >
                            @if ($list_categories)
                                @foreach ($list_categories as $item)   
                                    <div class="form-check">
                                            <input 
                                                type="checkbox" 
                                                name="product_categories[]" 
                                                value="{{$item['id']}}" 
                                                class="form-check-input form-check-inline" 
                                                id="exampleCheck-{{$item['id']}}" 
                                                @if (in_array($item['id'], $selected_categories_from_this_product))
                                                    checked
                                                @endif
                                            >
                                            <label class="form-check-label" for="exampleCheck-{{$item['id']}}">{{$item['name']}}</label>                      
                                    </div>
                                @endforeach 
                            @endif
                        <input 
                            type="hidden" 
                            name="selected_product_id" 
                            @if (isset($selected_product['id']))
                                value="{{$selected_product['id']}}"
                            @endif
                        >
                        <button type="submit" class="btn btn-primary mt-2">Изменить</button>
                    </div>
                </form>
                <p>Так же для этой модели(Product) реализовано удаление, создание, всё так же можете посмотреть в роутах. Почему не показываю это здесь, фронт это не моё. Я люблю программировать, а не странички верстать :)))<br/>Надеюсь поймёте и простите :)))</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>