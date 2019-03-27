#include <bits/stdc++.h>
#include <iostream> 

using namespace std;


int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];

  for(int i = 0; i < 15383; i++){
  	cin.std::istream::getline (s, 1000);
  	
    if(isdigit(s[0]) && isdigit(s[1])){
  		
      for(int j = 0; j < 6; j++){
        if(s[j] == ';'){
          cout << ';' << endl;
          break;
        }
        cout << s[j];
      }

      continue;
  	}
    
    cout << s << endl;
  }

  return 0;
}