<form method="POST" action="{{ url(route('order::create')) }}">
{!! csrf_field() !!}

    <div class="row">
        <div class="col-md-8">

			@if ( count($errors) > 0 || session('warning') )

			    @if (count($errors) > 0)
			    <div class="alert alert-danger alert-thin">
			        <i class="glyphicon glyphicon-exclamation-sign"></i> Encountered error(s) - Check submitted form for details.
			    </div>
			    @endif

			    @if (session('warning'))
			    <div class="alert alert-warning alert-thin">
			        <i class="glyphicon glyphicon-exclamation-sign"></i> {!! session('warning') !!}
			    </div>
			    @endif

			@endif

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has('get_quantity') || $errors->has('get_asset')) has-error @endif">
                        <label for="getQuantityInput">Buy:</label>
                        <div class="row">
                            <div class="col-sm-6 col-xs-4">
                                <input type="text" name="get_quantity" value="{{ ( isset($request) && ! empty($request->buy_qty) ? $request->buy_qty : old('get_quantity') ) }}" class="form-control input-lg" id="getQuantityInput" placeholder="0">
                                @if ($errors->has('get_quantity')) <p class="help-block">{{ $errors->first('get_quantity') }}</p> @endif
                            </div>
                            <div class="col-sm-6 col-xs-8" id="get_asset">
                                <input type="text" name="get_asset" value="{{ ( isset($request) && ! empty($request->buy) ? $request->buy : old('get_asset') ) }}" class="form-control input-lg typeahead" id="getAssetInput" placeholder="XCP" oninput="this.value=this.value.toUpperCase();">
                                @if ($errors->has('get_asset')) <p class="help-block">{{ $errors->first('get_asset') }}</p> @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has('give_quantity') || $errors->has('give_asset')) has-error @endif">
                        <label for="giveQuantityInput">Sell:</label>
                        <div class="row">
                            <div class="col-sm-6 col-xs-4">
                                <input type="text" name="give_quantity" value="{{  ( isset($request) && ! empty($request->sell_qty) ? $request->sell_qty : old('give_quantity') ) }}" class="form-control input-lg" id="giveQuantityInput" placeholder="0">
                                @if ($errors->has('give_quantity')) <p class="help-block">{{ $errors->first('give_quantity') }}</p> @endif
                            </div>
                            <div class="col-sm-6 col-xs-8" id="give_asset">
                                <input type="text" name="give_asset" value="{{  ( isset($request) && ! empty($request->sell) ? $request->sell : old('give_asset') ) }}" class="form-control input-lg typeahead" id="giveAssetInput" placeholder="XCP" oninput="this.value=this.value.toUpperCase();">
                                @if ($errors->has('give_asset')) <p class="help-block">{{ $errors->first('give_asset') }}</p> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group @if ($errors->has('source')) has-error @endif">
                        <label for="sourceInput">Source:</label>
                        <input type="text" name="source" value="{{ old('source') }}" class="form-control input-lg" id="sourceInput" placeholder="1CounterpartyXXXXXXXXXXXXXXXUWLpVr">
                        @if ($errors->has('source')) <p class="help-block">{{ $errors->first('source') }}</p> @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group @if ($errors->has('expiration')) has-error @endif">
                        <label for="getExpirationInput">Expire: <small># Blocks</small></label>
                        <input type="text" name="expiration" value="{{ ( old('expiration') ? old('expiration') : '144' ) }}" class="form-control input-lg" id="getExpirationInput" placeholder="144 = 1 DAY">
                        @if ($errors->has('expiration')) <p class="help-block">{{ $errors->first('expiration') }}</p> @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-lg btn-primary"><small><i class="glyphicon glyphicon-edit"></i></small> Generate Transaction</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>