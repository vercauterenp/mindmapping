<?php

class Controller_Ajax extends Controller_Rest {

    public function post_save() {
        if (Input::post()) {
            $json = $_POST['saveData'];
            $description = $_POST['saveDescription'];
            $image = $_POST['savePreview'];
            $date = Date::time()->get_timestamp();

            $idea = Model_Ideas::find_by_id($_POST['saveId']);
            $idea->idea = $json;
            $idea->preview = $image;
            $idea->description = $description;
            $idea->updated_at = $date;
            $idea->save();
        }
    }

    public function post_save_as() {
        if (Input::post()) {
            $json = $_POST['saveData'];
            $title = $_POST['saveTitle'];
            $image = $_POST['savePreview'];
            $description = $_POST['saveDescription'];

            $id_info = Auth::get_user_id();
            $date = Date::time()->get_timestamp();

            $idea = Model_Ideas::forge()->set(array(
                'title' => $title,
                'idea' => $json,
                'preview' => $image,
                'description' => $description,
                'user_id' => $id_info[1],
                'created_at' => $date,
                'updated_at' => $date
                    ));

            $idea->save();
            $this->response($idea->id);
        }
    }

    public function post_load_all() {
        $id_info = Auth::get_user_id();
        $result = DB::select('id', 'title')->from('ideas')->where('user_id', $id_info[1])->execute();
        $output = '';
        if (DB::count_last_query() != 0) {
            $output .= '<form id="loadOptions">';
            foreach ($result as $idea) {
                $output .= '<label class="radio">';
                $output .= '<input type="radio" name="loadOption" id="optionsRadios' . $idea['id'] . '" value="' . $idea['id'] . '" />';
                $output .= $idea['title'];
                $output .= '</label>';
            }
            $output .= '</form>';
        } else {
            $output .= '<p>There were no results!</p>';
        }

        $this->response($output);
    }

    public function post_load() {
        $value = $_POST['optionval'];
        $result = DB::select('idea', 'description')->from('ideas')->where('id', $value)->execute();
        $output = array();
        if (DB::count_last_query() != 0) {
            foreach ($result as $idea) {
                Arr::insert($output, $value, 0);
                Arr::insert($output, $idea['idea'], 1);
                Arr::insert($output, $idea['description'], 2);
            }
        }
        $this->response($output);
    }

    public function post_load_image() {
        $value = $_POST['optionval'];
        $result = DB::select('preview')->from('ideas')->where('id', $value)->execute();
        $output = '';
        if (DB::count_last_query() != 0) {
            foreach ($result as $idea) {
                $output = $idea['preview'];
            }
        }
        $this->response($output);
    }

}
