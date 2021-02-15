<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Exception;
use Validator;
use Illuminate\Support\Str;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class PatientController extends Controller
{
    protected $result = false;
    protected $message = 'Ocurrió un problema al procesar su solicitud';
    protected $records = array();
    protected $status_code = 400;
    
    public function index(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        $query = Patient::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

  
    public function store(Request $request)
    {
        try {
            $rules = [
                'name'              => 'required|min:5',
                'email'             => 'required|min:5',
                'phone'             => 'required',
                'ocupation'         => 'required',
                'weight'            => 'required',
                'height'            => 'required',
                'marital_status'    => 'required',
                'insurance'         => 'required',
                'birthdate'         => 'required'
            ];

            $messages = [
                'name.required'             => 'Es necesario que ingrese un nombre',
                'name.min'                  => 'El nombre debe contener más de 5 caracteres',
                'email.required'            => 'Es necesario que ingrese un correo electronico',
                'email.min'                 => 'El correo electronico debe contener más de 5 caracteres',
                'phone.required'            => 'Es necesario que ingrese un numero telefono',
                'ocupation.required'        => 'Es necesario que ingrese una ocupacion',
                'weight.required'           => 'Es necesario que ingrese un peso',
                'height.required'           => 'Es necesario que ingrese una estatura',
                'marital_status.required'   => 'Es necesario que seleccione un estado civil',
                'insurance.required'        => 'Es necesario que seleccione una aseguradora',
                'birthdate.required'        => 'Es necesario que ingese fecha de nacimiento',
              
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                throw new Exception($validator->messages()->first());
            } else {
                if ($request->input('tax_id')) {
                    $tax_id = $request->input('tax_id');
                } else {
                    $tax_id = 'CF';
                }     
                if ($request->input('name_tax')) {
                    $name_tax = $request->input('name_tax');
                } else {
                    $name_tax = 'Consumidor Final';
                }  
                $search = Patient::where('email',$request->input('email'))->first();
                if ($search) {
                    throw new Exception('El correo electronico ya esta registrado');
                 } else {
                    $data = Patient::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone'),
                        'ocupation' => $request->input('ocupation'),
                        'name_tax' => $name_tax,
                        'tax_id' => $tax_id,
                        'weight' => $request->input('weight'),
                        'height' => $request->input('height'),
                        'marital_status' => $request->input('marital_status'),
                        'insurance' => $request->input('insurance'),
                        'birthdate' => $request->input('birthdate'),
                        'password'  => bcrypt(Str::random(8)),
                    ]);
                    $this->status_code = 200;
                    $this->result = true;
                    $this->message = 'Registro creado correctamente';
                    $this->records = $data;
                }
                  
            }
        } catch (Exception $e) {
            $this->status_code = 200;
            $this->result = false;
            $this->message = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result' => $this->result,
                'message' => $this->message,
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }
    }

  
    public function show($id)
    {
        try {
            $data = Patient::find($id);
            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registro consultado correctamente';
            $this->records      = $data;
        } catch (Exception $e) {
            $this->status_code = 400;
            $this->result = false;
            $this->message = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result' => $this->result,
                'message' => $this->message,
                'records' => $data,
            ];

            return response()->json($response, $this->status_code);
        }
    }

  
    public function update(Request $request, $id)
    {
        try {
            $data = Patient::find($id);
            $data->name           = $request->input('name', $data->name);
            $data->email          = $request->input('email', $data->email);
            $data->phone          = $request->input('phone', $data->phone);
            $data->ocupation      = $request->input('ocupation', $data->ocupation);
            $data->name_tax       = $request->input('name_tax', $data->name_tax);
            $data->tax_id         = $request->input('tax_id', $data->tax_id);
            $data->weight         = $request->input('weight', $data->weight);
            $data->height         = $request->input('height', $data->height);
            $data->marital_status = $request->input('marital_status', $data->marital_status);
            $data->insurance      = $request->input('insurance', $data->insurance);
            $data->birthdate      = $request->input('birthdate', $data->birthdate);
            $data->save();
            $this->status_code = 200;
            $this->result      = true;
            $this->message     = 'Registro editado correctamente';
            $this->records     = $data;
        } catch (Exception $e) {
            $this->status_code = 400;
            $this->result = false;
            $this->message = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result' => $this->result,
                'message' => $this->message,
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }
    }

    public function destroy($id)
    {
        try {
            $data = Patient::find($id);
            $data->delete();
            $this->status_code = 200;
            $this->result = true;
            $this->message = 'Registro eliminado correctamente';
        } catch (Exception $e) {
            $this->status_code = 400;
            $this->result = false;
            $this->message = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result' => $this->result,
                'message' => $this->message,
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }
    }

}
